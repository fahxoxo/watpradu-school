@extends('layouts.admin')

@section('content')
<h3>แก้ไขรายการการเงิน - {{ $financial->topic }}</h3>

<form action="{{ route('financials.update', $financial) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">หัวข้อ</label>
        <input type="text" name="topic" class="form-control" value="{{ old('topic', $financial->topic) }}" required>
        @error('topic')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">ข้อความ</label>
        <textarea name="description" class="form-control" rows="6">{{ old('description', $financial->description) }}</textarea>
        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ (อัปโหลดเพื่อแทนที่รูปเดิม)</label>
        @if($financial->image)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$financial->image) }}" alt="{{ $financial->topic }}" style="max-width:200px; max-height:140px; object-fit:cover;">
            </div>
        @endif
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3">
        <button class="btn btn-success">อัพเดต</button>
        <a href="{{ route('financials.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
