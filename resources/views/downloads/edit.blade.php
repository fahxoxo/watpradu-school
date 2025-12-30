@extends('layouts.admin')

@section('content')
<h3>แก้ไขเอกสาร - {{ $download->topic }}</h3>

<form action="{{ route('downloads.update', $download) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">หัวข้อ</label>
        <input type="text" name="topic" class="form-control" value="{{ old('topic', $download->topic) }}" required>
        @error('topic')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ชื่อไฟล์ที่ต้องการแสดง</label>
        <input type="text" name="filename" class="form-control" value="{{ old('filename', $download->filename) }}" required>
        @error('filename')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ประเภทเอกสาร</label>
        <select name="type" class="form-select" required>
            <option value="">-- เลือกประเภท --</option>
            <option value="other" {{ old('type', $download->type) === 'other' ? 'selected' : '' }}>อื่นๆ</option>
            <option value="calendar" {{ old('type', $download->type) === 'calendar' ? 'selected' : '' }}>ปฏิทินการศึกษา</option>
            <option value="leave" {{ old('type', $download->type) === 'leave' ? 'selected' : '' }}>ใบลา</option>
            <option value="schedule" {{ old('type', $download->type) === 'schedule' ? 'selected' : '' }}>ตารางสอน</option>
        </select>
        @error('type')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ไฟล์ (PDF) - อัปโหลดเพื่อเพิ่มเป็นรายการใหม่ (ไม่แทนที่ไฟล์เดิม)</label>
        @if($download->file_path)
            <div class="mb-2">ไฟล์ปัจจุบัน: <a href="{{ route('downloads.download', $download) }}">ดาวน์โหลด</a></div>
        @endif
        <input type="file" name="file" class="form-control" accept="application/pdf">
        @error('file')<div class="text-danger">{{ $message }}</div>@enderror
        <div class="form-text">อัปโหลดไฟล์ PDF เท่านั้น (ไม่เกิน 10MB) — การอัปโหลดจะบันทึกเป็นรายการใหม่โดยไม่ลบไฟล์เดิม</div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">อัพเดต</button>
        <a href="{{ route('downloads.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
