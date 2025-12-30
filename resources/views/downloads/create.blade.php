@extends('layouts.admin')

@section('content')
<h3>เพิ่มเอกสารดาวน์โหลด</h3>

<form action="{{ route('downloads.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">หัวข้อ</label>
        <input type="text" name="topic" class="form-control" value="{{ old('topic') }}" required>
        @error('topic')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ชื่อไฟล์ที่ต้องการแสดง</label>
        <input type="text" name="filename" class="form-control" value="{{ old('filename') }}" required>
        @error('filename')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ประเภทเอกสาร</label>
        <select name="type" class="form-select" required>
            <option value="">-- เลือกประเภท --</option>
            <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>อื่นๆ</option>
            <option value="calendar" {{ old('type') === 'calendar' ? 'selected' : '' }}>ปฏิทินการศึกษา</option>
            <option value="leave" {{ old('type') === 'leave' ? 'selected' : '' }}>ใบลา</option>
            <option value="schedule" {{ old('type') === 'schedule' ? 'selected' : '' }}>ตารางสอน</option>
        </select>
        @error('type')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ไฟล์ (PDF)</label>
        <input type="file" name="file" class="form-control" accept="application/pdf" required>
        @error('file')<div class="text-danger">{{ $message }}</div>@enderror
        <div class="form-text">รองรับไฟล์ PDF ขนาดไม่เกิน 10MB</div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('downloads.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
