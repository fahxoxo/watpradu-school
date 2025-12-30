<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function publicIndex($type = 'other')
    {
        $downloads = Download::where('type', $type)->orderBy('id', 'desc')->get();
        $schoolInfo = SchoolInfo::first();
        
        // แมป type ไปยังชื่อที่แสดง
        $typeNames = [
            'other' => 'อื่นๆ',
            'calendar' => 'ปฏิทินการศึกษา',
            'leave' => 'ใบลา',
            'schedule' => 'ตารางสอน',
        ];
        
        $currentType = $typeNames[$type] ?? 'เอกสารดาวน์โหลด';
        
        return view('public.downloads', compact('downloads', 'schoolInfo', 'currentType', 'type'));
    }

    public function index()
    {
        $downloads = Download::orderBy('id', 'desc')->get();
        return view('downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('downloads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'filename' => 'required|string|max:255',
            'type' => 'required|in:other,calendar,leave,schedule',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('downloads', 'public');
            $data['file_path'] = $path;
        }

        Download::create($data);

        return redirect()->route('downloads.index')->with('success', 'บันทึกเอกสารเรียบร้อย');
    }

    public function edit(Download $download)
    {
        return view('downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'filename' => 'required|string|max:255',
            'type' => 'required|in:other,calendar,leave,schedule',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        // ถ้ามีการอัปโหลดไฟล์ใหม่: อย่าแทนที่ไฟล์เดิม แต่ให้บันทึกเป็นรายการใหม่
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('downloads', 'public');
            $newData = [
                'topic' => $data['topic'],
                'filename' => $data['filename'],
                'type' => $data['type'],
                'file_path' => $path,
            ];

            Download::create($newData);

            return redirect()->route('downloads.index')->with('success', 'อัปโหลดไฟล์ใหม่และบันทึกเป็นรายการใหม่เรียบร้อย');
        }

        // หากไม่มีการอัปโหลดไฟล์ ให้อัปเดตเฉพาะข้อมูลเมตา
        $download->update([
            'topic' => $data['topic'],
            'filename' => $data['filename'],
            'type' => $data['type'],
        ]);

        return redirect()->route('downloads.index')->with('success', 'อัพเดตข้อมูลเอกสารเรียบร้อย');
    }

    public function destroy(Download $download)
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }
        $download->delete();
        return redirect()->route('downloads.index')->with('success', 'ลบเอกสารเรียบร้อย');
    }

    public function download(Download $download)
    {
        if (! $download->file_path || ! Storage::disk('public')->exists($download->file_path)) {
            return redirect()->back()->with('error', 'ไฟล์ไม่พบ');
        }

        $ext = pathinfo($download->file_path, PATHINFO_EXTENSION);
        $name = $download->filename;
        if (! str_ends_with(strtolower($name), '.'.$ext)) {
            $name = $name . '.' . $ext;
        }

        // Use the physical path and response()->download to avoid static analysis warning about Storage::download
        $path = Storage::disk('public')->path($download->file_path);
        return response()->download($path, $name);
    }
}
