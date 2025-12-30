@extends('layouts.admin')

@section('content')
<h3>เพิ่มอาคาร</h3>

<form action="{{ route('buildings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">ชื่ออาคาร</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        <div class="form-text">ขนาดไฟล์แนะนำไม่เกิน 2MB (jpg/png)</div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
