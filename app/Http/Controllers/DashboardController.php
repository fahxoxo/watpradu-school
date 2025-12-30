<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\StudentStat;
use App\Models\Teacher;
use App\Models\Suggestion;
use Spatie\Activitylog\Models\Activity;
use ZipArchive;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงสถิตินักเรียนปีล่าสุด
        $latestStats = StudentStat::latest('academic_year')->first();
        $studentCount = $latestStats ? $latestStats->total_students : 0;
        
        $teacherCount = Teacher::count();
        $complaintCount = Suggestion::where('status', 'pending')->count();
        
        // Logs ล่าสุด (skip if activity_log table doesn't exist yet)
        if (Schema::hasTable('activity_log')) {
            $logs = Activity::latest()->take(5)->get();
        } else {
            $logs = collect();
        }

        // Get backup files
        $backups = $this->listBackups();

        return view('dashboard', compact('studentCount', 'teacherCount', 'complaintCount', 'logs', 'backups'));
    }

    /**
     * List available backup files
     */
    public function listBackups()
    {
        $backupDir = storage_path('app/backup-temp');
        
        if (!is_dir($backupDir)) {
            return [];
        }

        $files = array_diff(scandir($backupDir, SCANDIR_SORT_DESCENDING), ['.', '..']);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $filePath = $backupDir . '/' . $file;
                $size = filesize($filePath);
                // Format bytes to readable size
                $units = ['B', 'KB', 'MB', 'GB'];
                $bytes = max($size, 0);
                $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                $pow = min($pow, count($units) - 1);
                $bytes /= (1 << (10 * $pow));
                $sizeFormatted = round($bytes, 2) . ' ' . $units[$pow];
                
                $backups[] = [
                    'filename' => $file,
                    'size' => $sizeFormatted,
                    'date' => date('Y-m-d H:i:s', filemtime($filePath)),
                    'timestamp' => filemtime($filePath),
                ];
            }
        }

        return collect($backups)->sortByDesc('timestamp')->values();
    }

    public function backup(Request $request)
    {
        try {
            $backupDir = storage_path('app/backup-temp');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Create backup filename
            $timestamp = date('Y-m-d_H-i-s');
            $backupFile = $backupDir . '/backup_' . $timestamp . '.zip';

            // Create zip archive
            $zip = new ZipArchive();
            if ($zip->open($backupFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('ไม่สามารถสร้างไฟล์ ZIP ได้');
            }

            // Add database file
            $dbPath = database_path('database.sqlite');
            if (file_exists($dbPath)) {
                $zip->addFile($dbPath, 'database/database.sqlite');
            }

            // Add project files (skip node_modules, vendor, storage)
            $this->addFilesToZip($zip, base_path(), '', ['node_modules', 'vendor', 'storage/logs', '.git', '.env.local']);

            $zip->close();

            return back()->with('success', '✅ Backup สำเร็จ! ไฟล์: ' . filesize($backupFile) . ' bytes');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Backup ล้มเหลว: ' . $e->getMessage());
        }
    }

    /**
     * Recursively add files to zip archive
     */
    private function addFilesToZip(&$zip, $path, $zipPath = '', $skipDirs = [])
    {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || in_array($file, $skipDirs)) {
                continue;
            }

            $filePath = $path . '/' . $file;
            $newZipPath = $zipPath ? $zipPath . '/' . $file : $file;

            if (is_dir($filePath)) {
                $this->addFilesToZip($zip, $filePath, $newZipPath, $skipDirs);
            } else {
                $zip->addFile($filePath, $newZipPath);
            }
        }
    }

    /**
     * Restore from backup file
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string',
        ]);

        $backupFile = basename($request->backup_file); // Prevent directory traversal
        $backupPath = storage_path('app/backup-temp/' . $backupFile);

        if (!file_exists($backupPath) || pathinfo($backupPath, PATHINFO_EXTENSION) !== 'zip') {
            return back()->with('error', 'ไฟล์ backup ไม่พบ หรือไฟล์ไม่ถูกต้อง');
        }

        try {
            // Create temporary extract directory
            $extractDir = storage_path('app/backup-restore-temp');
            if (!is_dir($extractDir)) {
                mkdir($extractDir, 0755, true);
            }

            // Extract zip
            $zip = new ZipArchive();
            if ($zip->open($backupPath) !== true) {
                return back()->with('error', 'ไม่สามารถเปิดไฟล์ ZIP ได้');
            }

            $zip->extractTo($extractDir);
            $zip->close();

            // Find and restore database dump
            $dumpFile = null;
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($extractDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql' && strpos($file, 'database') !== false) {
                    $dumpFile = $file;
                    break;
                }
            }

            if ($dumpFile && file_exists($dumpFile)) {
                // Restore SQLite database
                $sqlDump = file_get_contents($dumpFile);
                DB::unprepared($sqlDump);
            }

            // Clean up
            $this->deleteDirectory($extractDir);

            return back()->with('success', 'Restore สำเร็จ! ข้อมูลได้ถูกนำกลับมา');
        } catch (\Exception $e) {
            return back()->with('error', 'Restore ล้มเหลว: ' . $e->getMessage());
        }
    }

    /**
     * Delete directory recursively
     */
    private function deleteDirectory($path)
    {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $path . '/' . $file;
                is_dir($filePath) ? $this->deleteDirectory($filePath) : unlink($filePath);
            }
            rmdir($path);
        }
    }
}