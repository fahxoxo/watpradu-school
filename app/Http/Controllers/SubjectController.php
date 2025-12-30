<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('id', 'desc')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
        ]);

        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'บันทึกข้อมูลวิชาเรียบร้อย');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'อัพเดตข้อมูลวิชาเรียบร้อย');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'ลบข้อมูลวิชาเรียบร้อย');
    }
}
