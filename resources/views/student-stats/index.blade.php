@extends('layouts.admin')

@section('content')
<h3>ข้อมูลสถิติ นักเรียน</h3>

<div class="mb-3">
    <a href="{{ route('student-stats.create') }}" class="btn btn-primary">+ เพิ่มสถิติใหม่</a>
</div>

@if($stats->isEmpty())
    <div class="alert alert-info">ยังไม่มีข้อมูลสถิติ</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ปีการศึกษา</th>
            <th>ชาย</th>
            <th>หญิง</th>
            <th>รวม</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stats as $s)
        <tr>
            <td>{{ $s->academic_year }}</td>
            <td>{{ $s->count_male }}</td>
            <td>{{ $s->count_female }}</td>
            <td>{{ $s->total_students }}</td>
            <td>
                <a href="{{ route('student-stats.edit', $s) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('student-stats.destroy', $s) }}" method="POST" style="display:inline" onsubmit="return confirm('แน่ใจหรือจะลบข้อมูลนี้?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection