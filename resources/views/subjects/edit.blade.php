@extends('layouts.admin')

@section('content')
<h3>แก้ไขวิชา</h3>

<form action="{{ route('subjects.update', $subject) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">รหัสวิชา</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required>
        @error('code')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ชื่อวิชา</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ชื่ออาจารย์ผู้สอน</label>
        <input type="text" name="teacher_name" class="form-control" value="{{ old('teacher_name', $subject->teacher_name) }}" required>
        @error('teacher_name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
