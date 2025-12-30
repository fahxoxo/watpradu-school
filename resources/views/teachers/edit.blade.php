@extends('layouts.admin')

@section('content')
<h3>แก้ไขบุคลากร</h3>

<form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">ชื่อ</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">เบอร์โทร</label>
        <input type="text" name="tel" class="form-control" value="{{ old('tel', $teacher->tel) }}">
        @error('tel')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">อีเมล์</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}">
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ตำแหน่ง</label>
        <input type="text" name="position" class="form-control" value="{{ old('position', $teacher->position) }}">
        @error('position')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพปัจจุบัน</label>
        @if($teacher->image)
            <div><img src="{{ asset($teacher->image) }}" alt="{{ $teacher->name }}" style="max-width:120px; max-height:120px; object-fit:cover;"></div>
        @else
            <div>-</div>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">เปลี่ยนรูปภาพ</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection