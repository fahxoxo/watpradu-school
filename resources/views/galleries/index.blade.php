@extends('layouts.admin')

@section('content')
<h3>อัลบั้มภาพ</h3>

<div class="mb-3">
    <a href="{{ route('galleries.create') }}" class="btn btn-primary">+ สร้างอัลบั้มใหม่</a>
</div>

@if($galleries->isEmpty())
    <div class="alert alert-info">ยังไม่มีอัลบั้ม</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ชื่ออัลบั้ม</th>
            <th>จำนวนรูป</th>
            <th>วันที่สร้าง</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($galleries as $g)
        <tr>
            <td>{{ $g->activity_name }}</td>
            <td>{{ $g->images_count }}</td>
            <td>{{ $g->created_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('galleries.show', $g) }}" class="btn btn-sm btn-info">ดูรูป</a>
                <form action="{{ route('galleries.destroy', $g) }}" method="POST" style="display:inline" onsubmit="return confirm('แน่ใจหรือจะลบอัลบั้มนี้?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection