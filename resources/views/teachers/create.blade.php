@extends('layouts.admin')

@section('content')
<h3>เพิ่มบุคลากร</h3>

<form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">ชื่อ</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">เบอร์โทร</label>
        <input type="text" name="tel" class="form-control" value="{{ old('tel') }}">
        @error('tel')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">อีเมล์</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ตำแหน่ง</label>
        <input type="text" name="position" class="form-control" value="{{ old('position') }}">
        @error('position')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        <div class="form-text">ขนาดแนะนำไม่เกิน 2MB (jpg/png)</div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection