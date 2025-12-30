@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>เพิ่มกิจกรรมใหม่</h3>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">← ย้อนกลับ</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <!-- ชื่อกิจกรรม -->
            <div class="mb-4">
                <label class="form-label fw-bold">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                <textarea 
                    name="title" 
                    id="title"
                    class="form-control @error('title') is-invalid @enderror" 
                    maxlength="1000" 
                    rows="3" 
                    placeholder="เช่น ทำบุญตักบาตร, กีฬาสี, ค่ายลูกเสือ, ฯลฯ"
                    required>{{ old('title') }}</textarea>
                @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block mt-2">
                    ความยาว: <strong id="char-count">{{ strlen(old('title', '')) }}</strong>/1000
                </small>
            </div>

            <!-- วันที่ -->
            <div class="mb-4">
                <label class="form-label fw-bold">วันที่ <span class="text-danger">*</span></label>
                <input 
                    type="date" 
                    name="event_date" 
                    id="event_date"
                    class="form-control @error('event_date') is-invalid @enderror"
                    value="{{ old('event_date', request('event_date', '')) }}"
                    required>
                @error('event_date')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block mt-2">เลือกวันที่จัดกิจกรรม</small>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 pt-3 border-top">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">ยกเลิก</a>
                <button type="submit" class="btn btn-primary">บันทึกกิจกรรม</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('title').addEventListener('input', function(){
    document.getElementById('char-count').textContent = this.value.length;
});
</script>
@endsection
