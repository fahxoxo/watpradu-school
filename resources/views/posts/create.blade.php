@extends('layouts.admin')

@section('content')
<h3>เพิ่มข่าว/กิจกรรม</h3>

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">ชื่อหัวข้อ</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        @error('title')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">เนื้อหา</label>
        <textarea name="content" class="form-control" rows="6">{{ old('content') }}</textarea>
        @error('content')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ (ไม่เกิน 1 รูป)</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">แท็ก / คำสำคัญ (คั่นด้วย comma)</label>
        <input type="text" name="tags" class="form-control" value="{{ old('tags') }}">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">ประเภท</label>
            <select name="type" class="form-control" required>
                <option value="news">ข่าว</option>
                <option value="activity">กิจกรรม</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">ปักหมุด</label>
            <select name="pinned" class="form-control">
                <option value="unpinned">ไม่ปักหมุด</option>
                <option value="pinned">ปักหมุด</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('posts.admin.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection