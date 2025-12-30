@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>การเงิน</h3>
    <a href="{{ route('financials.create') }}" class="btn btn-primary">+ เพิ่มรายการ</a>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>หัวข้อ</th>
            <th>ข้อความ</th>
            <th>รูปภาพ</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $it)
        <tr>
            <td style="width:220px">{{ $it->topic }}</td>
            <td>{{ Str::limit(strip_tags($it->description), 200) }}</td>
            <td style="width:150px">
                @if($it->image)
                    <img src="{{ asset('storage/'.$it->image) }}" alt="{{ $it->topic }}" style="max-width:120px; max-height:80px; object-fit:cover;">
                @else
                    -
                @endif
            </td>
            <td style="white-space:nowrap;">
                <a href="{{ route('financials.edit', $it) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('financials.destroy', $it) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบรายการการเงิน?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4">ยังไม่มีข้อมูล</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
