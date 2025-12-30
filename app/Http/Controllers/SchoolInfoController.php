<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SchoolInfo;


class SchoolInfoController extends Controller
{
    public function edit()
    {
        $info = SchoolInfo::first();
        return view('school-info.edit', compact('info'));
    }

    public function update(Request $request)
    {
        $info = SchoolInfo::firstOrNew(); // ถ้าไม่มีให้สร้างใหม่ ถ้ามีให้ดึงมา

        // Validation
        $request->validate([
            'schoolname' => 'nullable|string|max:255',
            'history' => 'nullable|string',
            'motto' => 'nullable|string|max:500',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'tel' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|max:2048',
            'screen' => 'nullable|image|max:4096',
        ]);

        // จัดการอัพโหลดรูป Logo
        if ($request->hasFile('logo')) {
            // ลบไฟล์เก่าถ้ามี
            if (!empty($info->logo)) {
                Storage::disk('public')->delete(str_replace('storage/', '', $info->logo));
            }

            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('school', $file, $filename);
            $info->logo = asset('storage/' . $path);
        }

        // จัดการอัพโหลดรูป Screen
        if ($request->hasFile('screen')) {
            if (!empty($info->screen)) {
                Storage::disk('public')->delete(str_replace('storage/', '', $info->screen));
            }

            $file = $request->file('screen');
            $filename = 'screen_' . time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('school', $file, $filename);
            $info->screen = asset('storage/' . $path);
        }

        // จัดการอัพโหลดรูป Map (optional)
        if ($request->hasFile('map_image')) {
            if (!empty($info->map_image)) {
                Storage::disk('public')->delete(str_replace('storage/', '', $info->map_image));
            }

            $file = $request->file('map_image');
            $filename = 'map_' . time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('school', $file, $filename);
            $info->map_image = asset('storage/' . $path);
        }

        // บันทึกฟิลด์อื่น ๆ
        $info->schoolname = $request->input('schoolname');
        $info->history = $request->input('history');
        $info->motto = $request->input('motto');
        $info->vision = $request->input('vision');
        $info->mission = $request->input('mission');
        $info->tel = $request->input('tel');
        $info->address = $request->input('address');
        $info->email = $request->input('email');

        $info->save();

        return redirect()->route('school-info.edit')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
