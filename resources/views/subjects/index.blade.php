@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>ข้อมูลทางวิชาการ</h3>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ เพิ่มวิชา</a>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>รหัสวิชา</th>
            <th>ชื่อวิชา</th>
            <th>อาจารย์ผู้สอน</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($subjects as $s)
        <tr>
            <td>{{ $s->code }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->teacher_name }}</td>
            <td style="white-space:nowrap;">
                <a href="{{ route('subjects.edit', $s) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('subjects.destroy', $s) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบวิชา {{ $s->name }} ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4">ยังไม่มีข้อมูลวิชา</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
