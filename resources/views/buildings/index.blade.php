@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>อาคารสถานที่</h3>
    <a href="{{ route('buildings.create') }}" class="btn btn-primary">+ เพิ่มอาคาร</a>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>ชื่ออาคาร</th>
            <th>รูปภาพ</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($buildings as $b)
        <tr>
            <td>{{ $b->name }}</td>
            <td>
                @if($b->image)
                    <img src="{{ asset('storage/'.$b->image) }}" alt="{{ $b->name }}" style="max-width:120px; max-height:80px; object-fit:cover;">
                @else
                    -
                @endif
            </td>
            <td style="white-space:nowrap;">
                <a href="{{ route('buildings.edit', $b) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('buildings.destroy', $b) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบอาคาร {{ $b->name }} ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="3">ยังไม่มีข้อมูลอาคาร</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
