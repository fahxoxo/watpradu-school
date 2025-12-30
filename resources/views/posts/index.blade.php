@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>ข่าวและกิจกรรม</h3>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">+ เพิ่ม</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="ค้นหาชื่อข่าว/คำสำคัญ">
    </div>
    <div class="col-md-2">
        <select name="type" class="form-control">
            <option value="">ทั้งหมด</option>
            <option value="news" {{ request('type')=='news' ? 'selected' : '' }}>ข่าว</option>
            <option value="activity" {{ request('type')=='activity' ? 'selected' : '' }}>กิจกรรม</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <button class="btn btn-secondary">กรอง</button>
        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">รีเซ็ต</a>
    </div>
</form>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>หัวข้อ</th>
            <th>ประเภท</th>
            <th>คำค้น</th>
            <th>ปักหมุด</th>
            <th>สถานะ</th>
            <th>วันที่</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $p)
        <tr>
            <td>{{ $p->title }}</td>
            <td>{{ $p->type }}</td>
            <td>{{ $p->tags }}</td>
            <td>{{ $p->pinned ? 'ปักหมุด' : '-' }}</td>
            <td>
                <input type="checkbox" class="toggle-active" data-id="{{ $p->id }}" {{ $p->active ? 'checked' : '' }}>
            </td>
            <td>{{ $p->created_at->format('Y-m-d') }}</td>
            <td style="white-space:nowrap;">
                <a href="{{ route('posts.edit', $p) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                <form action="{{ route('posts.destroy', $p) }}" method="POST" style="display:inline" onsubmit="return confirm('ยืนยันการลบ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7">ยังไม่มีข้อมูล</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.toggle-active').forEach(el => {
        el.addEventListener('change', function(){
            const id = this.dataset.id;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/posts/${id}/toggle`, { method: 'POST', headers: { 'X-CSRF-TOKEN': token } })
                .then(r => r.json())
                .then(data => {
                    // optional: show toast
                });
        });
    });
</script>
@endsection