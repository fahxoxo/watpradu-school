@extends('layouts.admin')

@section('content')
<h3>แก้ไขข้อเสนอแนะ</h3>

<form action="{{ route('suggestions.update', $suggestion) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">ชื่อผู้เสนอ</label>
        <input type="text" class="form-control" value="{{ $suggestion->submitter_name }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">ข้อความ</label>
        <textarea class="form-control" rows="6" readonly>{{ $suggestion->message }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">สถานะ</label>
        <select name="status" class="form-select" required>
            <option value="pending" {{ $suggestion->status === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
            <option value="processing" {{ $suggestion->status === 'processing' ? 'selected' : '' }}>กำลังดำเนินการ</option>
            <option value="completed" {{ $suggestion->status === 'completed' ? 'selected' : '' }}>ดำเนินการแล้ว</option>
        </select>
        @error('status')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('suggestions.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
