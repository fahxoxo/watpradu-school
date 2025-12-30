<?php

namespace App\Http\Controllers;

use App\Models\StudentStat;
use Illuminate\Http\Request;

class StudentStatController extends Controller
{
    public function publicIndex()
    {
        $stats = StudentStat::orderBy('academic_year', 'desc')->get();
        $schoolInfo = \App\Models\SchoolInfo::first();
        return view('public.students', compact('stats', 'schoolInfo'));
    }

    public function publicDetail(StudentStat $studentStat)
    {
        $stat = $studentStat;
        $schoolInfo = \App\Models\SchoolInfo::first();
        return view('public.students-detail', compact('stat', 'schoolInfo'));
    }

    public function index()
    {
        $stats = StudentStat::orderBy('academic_year', 'desc')->get();
        return view('student-stats.index', compact('stats'));
    }

    public function create()
    {
        return view('student-stats.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'academic_year' => 'required|string|max:255',
            'grade_k1_boys' => 'required|integer|min:0',
            'grade_k1_girls' => 'required|integer|min:0',
            'grade_k2_boys' => 'required|integer|min:0',
            'grade_k2_girls' => 'required|integer|min:0',
            'grade_k3_boys' => 'required|integer|min:0',
            'grade_k3_girls' => 'required|integer|min:0',
            'grade_p1_boys' => 'required|integer|min:0',
            'grade_p1_girls' => 'required|integer|min:0',
            'grade_p2_boys' => 'required|integer|min:0',
            'grade_p2_girls' => 'required|integer|min:0',
            'grade_p3_boys' => 'required|integer|min:0',
            'grade_p3_girls' => 'required|integer|min:0',
            'grade_p4_boys' => 'required|integer|min:0',
            'grade_p4_girls' => 'required|integer|min:0',
            'grade_p5_boys' => 'required|integer|min:0',
            'grade_p5_girls' => 'required|integer|min:0',
            'grade_p6_boys' => 'required|integer|min:0',
            'grade_p6_girls' => 'required|integer|min:0',
            'grade_m1_boys' => 'required|integer|min:0',
            'grade_m1_girls' => 'required|integer|min:0',
            'grade_m2_boys' => 'required|integer|min:0',
            'grade_m2_girls' => 'required|integer|min:0',
            'grade_m3_boys' => 'required|integer|min:0',
            'grade_m3_girls' => 'required|integer|min:0',
        ]);

        StudentStat::create($data);

        return redirect()->route('student-stats.index')->with('success', 'บันทึกข้อมูลสถิติ นักเรียนเรียบร้อย');
    }

    public function edit(StudentStat $studentStat)
    {
        return view('student-stats.edit', compact('studentStat'));
    }

    public function update(Request $request, StudentStat $studentStat)
    {
        $data = $request->validate([
            'academic_year' => 'required|string|max:255',
            'grade_k1_boys' => 'required|integer|min:0',
            'grade_k1_girls' => 'required|integer|min:0',
            'grade_k2_boys' => 'required|integer|min:0',
            'grade_k2_girls' => 'required|integer|min:0',
            'grade_k3_boys' => 'required|integer|min:0',
            'grade_k3_girls' => 'required|integer|min:0',
            'grade_p1_boys' => 'required|integer|min:0',
            'grade_p1_girls' => 'required|integer|min:0',
            'grade_p2_boys' => 'required|integer|min:0',
            'grade_p2_girls' => 'required|integer|min:0',
            'grade_p3_boys' => 'required|integer|min:0',
            'grade_p3_girls' => 'required|integer|min:0',
            'grade_p4_boys' => 'required|integer|min:0',
            'grade_p4_girls' => 'required|integer|min:0',
            'grade_p5_boys' => 'required|integer|min:0',
            'grade_p5_girls' => 'required|integer|min:0',
            'grade_p6_boys' => 'required|integer|min:0',
            'grade_p6_girls' => 'required|integer|min:0',
            'grade_m1_boys' => 'required|integer|min:0',
            'grade_m1_girls' => 'required|integer|min:0',
            'grade_m2_boys' => 'required|integer|min:0',
            'grade_m2_girls' => 'required|integer|min:0',
            'grade_m3_boys' => 'required|integer|min:0',
            'grade_m3_girls' => 'required|integer|min:0',
        ]);

        $studentStat->update($data);

        return redirect()->route('student-stats.index')->with('success', 'อัพเดตข้อมูลสถิติ นักเรียนเรียบร้อย');
    }

    public function destroy(StudentStat $studentStat)
    {
        $studentStat->delete();
        return redirect()->route('student-stats.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}