@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>ข้อเสนอแนะ</h3>
    <div>
        <a href="{{ route('suggestions.export') }}" class="btn btn-outline-primary">📤 Export (30 วัน)</a>
    </div>
</div>

<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>วันที่</th>
            <th>ชื่อผู้เสนอ</th>
            <th>ข้อความ</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suggestions as $s)
        <tr>
            <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $s->submitter_name ?? ($s->user->name ?? '-') }}</td>
            <td style="max-width:480px;">{{ Str::limit($s->message, 200) }}</td>
            <td>
                @if($s->status === 'pending')
                    <span class="badge bg-secondary">รอดำเนินการ</span>
                @elseif($s->status === 'processing')
                    <span class="badge bg-warning">กำลังดำเนินการ</span>
                @else
                    <span class="badge bg-success">ดำเนินการแล้ว</span>
                @endif
            </td>
            <td style="white-space:nowrap;">
                <a href="{{ route('suggestions.edit', $s) }}" class="btn btn-sm btn-warning">แก้ไข</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">ยังไม่มีข้อเสนอแนะ</td></tr>
        @endforelse
    </tbody>
</table>

{{ $suggestions->links() }}
@endsection
