@extends('layouts.admin')

@section('content')
<h3>เพิ่มรายการการเงิน</h3>

<form action="{{ route('financials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">หัวข้อ</label>
        <input type="text" name="topic" class="form-control" value="{{ old('topic') }}" required>
        @error('topic')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ข้อความ</label>
        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        <div class="form-text">ขนาดไฟล์แนะนำไม่เกิน 2MB (jpg/png)</div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('financials.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
