@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>เอกสารดาวน์โหลด</h3>
    <a href="{{ route('downloads.create') }}" class="btn btn-primary">+ เพิ่มเอกสาร</a>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>หัวข้อ</th>
            <th>ชื่อไฟล์ที่แสดง</th>
            <th>ประเภท</th>
            <th></th>
            <th>ไฟล์</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($downloads as $d)
        <tr>
            <td>{{ $d->topic }}</td>
            <td>{{ $d->filename }}</td>
            <td>
                @switch($d->type)
                    @case('other')
                        <span class="badge bg-secondary">อื่นๆ</span>
                        @break
                    @case('calendar')
                        <span class="badge bg-primary">ปฏิทินการศึกษา</span>
                        @break
                    @case('leave')
                        <span class="badge bg-info">ใบลา</span>
                        @break
                    @case('schedule')
                        <span class="badge bg-warning">ตารางสอน</span>
                        @break
                    @default
                        <span class="badge bg-light">{{ $d->type }}</span>
                @endswitch
            </td>
            <td>
            <td>
                @if($d->file_path)
                    <a href="{{ route('downloads.download', $d) }}" class="btn btn-sm btn-success">ดาวน์โหลด</a>
                @else
                    -
                @endif
            </td>
            <td style="white-space:nowrap;">
                <a href="{{ route('downloads.edit', $d) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('downloads.destroy', $d) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบเอกสาร {{ $d->topic }} ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4">ยังไม่มีเอกสาร</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
