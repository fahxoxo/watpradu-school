@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3>ปฏิทินกิจกรรม</h3>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ← ย้อนกลับ
        </a>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            + เพิ่มกิจกรรม
        </a>
    </div>
</div>

<!-- Events List -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">กิจกรรมทั้งหมด</h5>
    </div>
    <div class="card-body">
        @if($events->isEmpty())
            <div class="alert alert-info mb-0">ยังไม่มีกิจกรรม</div>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>วันที่</th>
                            <th>ชื่อกิจกรรม</th>
                            <th style="width: 150px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td style="font-size: 0.9rem; white-space: nowrap;">
                                <strong>{{ $event->start_time?->format('d/m/Y') }}</strong>
                            </td>
                            <td style="font-size: 0.9rem;">
                                {{ $event->title }}
                            </td>
                            <td style="font-size: 0.9rem;">
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
