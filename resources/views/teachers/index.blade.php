@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>ผู้บริหาร/บุคลากร</h3>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">+ เพิ่มบุคลากร</a>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ผังโครงสร้างบุคลากร</h5>
                @if(!empty($info) && $info->map_image)
                    <img src="{{ asset($info->map_image) }}" alt="Map" class="img-fluid mb-3">
                    <form action="{{ route('teachers.map.destroy') }}" method="POST" onsubmit="return confirm('ลบผังบุคลากรใช่หรือไม่?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">ลบผัง</button>
                    </form>
                @else
                    <div class="alert alert-secondary">ยังไม่มีผัง</div>
                @endif

                <hr>
                <form action="{{ route('teachers.map.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">อัพโหลดผัง (ไฟล์รูปภาพเดียว)</label>
                        <input type="file" name="map_image" class="form-control" required>
                        @error('map_image')<div class="text-danger">{{ $message }}</div>@enderror
                        <div class="form-text">ไฟล์จะทับของเดิมอัตโนมัติ (jpg/png) ขนาดไม่เกิน 8MB</div>
                    </div>
                    <button class="btn btn-success">อัพโหลด / แทนที่</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">สรุปบุคลากร</h5>
                <p>จำนวนปัจจุบัน: <strong>{{ $teachers->count() }}</strong> / 100</p>
                <p>สามารถเพิ่มและจัดการข้อมูลผู้บริหารและบุคลากรได้ที่ตารางด้านล่าง</p>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>ชื่อ</th>
            <th>โทร</th>
            <th>อีเมล์</th>
            <th>ตำแหน่ง</th>
            <th>รูป</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($teachers as $t)
        <tr>
            <td>{{ $t->name }}</td>
            <td>{{ $t->tel }}</td>
            <td>{{ $t->email }}</td>
            <td>{{ $t->position }}</td>
            <td>
                @if($t->image)
                    <img src="{{ asset($t->image) }}" alt="{{ $t->name }}" style="max-width:80px; max-height:80px; object-fit:cover;">
                @else
                    -
                @endif
            </td>
            <td style="white-space:nowrap;">
                <a href="{{ route('teachers.edit', $t) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('teachers.destroy', $t) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบ {{ $t->name }} ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">ยังไม่มีข้อมูลบุคลากร</td></tr>
        @endforelse
    </tbody>
</table>
@endsection