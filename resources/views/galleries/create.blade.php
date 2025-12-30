@extends('layouts.admin')

@section('content')
<h3>สร้างอัลบั้มภาพใหม่</h3>

<form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">ชื่อกิจกรรม/อัลบั้ม</label>
        <input type="text" name="activity_name" class="form-control" value="{{ old('activity_name') }}" required>
        @error('activity_name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">เลือกรูปภาพ (เลือกหลายไฟล์ได้)</label>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        @error('images.*')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div>
        <button class="btn btn-success">อัปโหลด</button>
        <a href="{{ route('galleries.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>

@endsection