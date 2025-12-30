<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('id', 'desc')->get();
        $info = SchoolInfo::first();
        return view('teachers.index', compact('teachers', 'info'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'tel' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if (Teacher::count() >= 100) {
            return redirect()->back()->with('error', 'จำนวนครูสูงสุด 100 ราย ไม่สามารถเพิ่มได้อีก');
        }

        $data = $request->only(['name','tel','email','position']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file)
                ->scaleDown(width: 600)
                ->toJpeg(quality: 85);

            $filename = 'teachers/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $image);
            $data['image'] = 'storage/' . $filename;
        }

        Teacher::create($data);

        return redirect()->route('teachers.index')->with('success', 'บันทึกข้อมูลบุคลากรเรียบร้อย');
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'tel' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','tel','email','position']);

        if ($request->hasFile('image')) {
            // delete old image
            if ($teacher->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $teacher->image));
            }

            $file = $request->file('image');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file)
                ->scaleDown(width: 600)
                ->toJpeg(quality: 85);

            $filename = 'teachers/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $image);
            $data['image'] = 'storage/' . $filename;
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'อัพเดตข้อมูลบุคลากรเรียบร้อย');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $teacher->image));
        }
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'ลบข้อมูลบุคลากรเรียบร้อย');
    }

    // Map management (single file stored in school_info.map_image)
    public function mapUpdate(Request $request)
    {
        $request->validate([
            'map_image' => 'required|image|max:8192',
        ]);

        $info = SchoolInfo::firstOrNew();

        if ($request->hasFile('map_image')) {
            if (!empty($info->map_image)) {
                Storage::disk('public')->delete(str_replace('storage/', '', $info->map_image));
            }

            $file = $request->file('map_image');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file)
                ->scaleDown(width: 1600)
                ->toJpeg(quality: 85);

            $filename = 'school/map_' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $image);
            $info->map_image = 'storage/' . $filename;
            $info->save();
        }

        return redirect()->route('teachers.index')->with('success', 'อัพโหลดผังบุคลากรเรียบร้อย');
    }

    public function mapDestroy()
    {
        $info = SchoolInfo::first();
        if ($info && $info->map_image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $info->map_image));
            $info->map_image = null;
            $info->save();
        }
        return redirect()->route('teachers.index')->with('success', 'ลบผังบุคลากรเรียบร้อย');
    }

    // Public methods for displaying teacher information
    public function publicIndex()
    {
        $teachers = Teacher::orderBy('id', 'asc')->get();
        $schoolInfo = SchoolInfo::first();
        return view('public.teachers', compact('teachers', 'schoolInfo'));
    }

    public function publicShow(Teacher $teacher)
    {
        $schoolInfo = SchoolInfo::first();
        return view('public.teacher', compact('teacher', 'schoolInfo'));
    }
}
