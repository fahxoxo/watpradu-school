@extends('layouts.admin')

@section('content')
<h3>แก้ไขอาคาร - {{ $building->name }}</h3>

<form action="{{ route('buildings.update', $building) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">ชื่ออาคาร</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $building->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ (อัปโหลดเพื่อแทนที่รูปเดิม)</label>
        @if($building->image)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$building->image) }}" alt="{{ $building->name }}" style="max-width:200px; max-height:140px; object-fit:cover;">
            </div>
        @endif
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3">
        <button class="btn btn-success">อัพเดต</button>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
