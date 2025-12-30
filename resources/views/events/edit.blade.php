@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>แก้ไขกิจกรรม</h3>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">← ย้อนกลับ</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

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
                    required>{{ old('title', $event->title) }}</textarea>
                @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block mt-2">
                    ความยาว: <strong id="char-count">{{ strlen(old('title', $event->title)) }}</strong>/1000
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
                    value="{{ old('event_date', $event->start_time?->format('Y-m-d')) }}"
                    required>
                @error('event_date')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block mt-2">เลือกวันที่จัดกิจกรรม</small>
            </div>

            <!-- Info -->
            <div class="alert alert-info small mb-4">
                <strong>วันที่สร้าง:</strong> {{ $event->created_at->format('d/m/Y H:i') }} | 
                <strong>แก้ไขล่าสุด:</strong> {{ $event->updated_at->format('d/m/Y H:i') }}
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 pt-3 border-top">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">ยกเลิก</a>
                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Form -->
<div class="card shadow-sm mt-4 border-danger">
    <div class="card-body">
        <h5 class="text-danger mb-3">⚠️ โซนอันตราย</h5>
        <p class="text-muted mb-3">กดปุ่มด้านล่างเพื่อลบกิจกรรมนี้ (ไม่สามารถกู้คืนได้)</p>
        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบกิจกรรมนี้? การดำเนินการนี้ไม่สามารถยกเลิกได้');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">ลบกิจกรรม</button>
        </form>
    </div>
</div>

<script>
document.getElementById('title').addEventListener('input', function(){
    document.getElementById('char-count').textContent = this.value.length;
});
</script>
@endsection
