<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use App\Models\StudentStat;
use App\Models\Teacher;
use App\Models\Suggestion;
use Spatie\Activitylog\Models\Activity; // เรียกใช้ Log

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

        return view('dashboard', compact('studentCount', 'teacherCount', 'complaintCount', 'logs'));
    }

    public function backup(Request $request)
    {
        try {
            Artisan::call('backup:run');
            $output = Artisan::output();
            return back()->with('success', 'Backup started. ' . \Illuminate\Support\Str::limit($output, 200));
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
}