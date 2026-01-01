@extends('layouts.admin')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">แดชบอร์ด</h1>
        <div class="d-flex gap-2">
            <form action="{{ route('backup.run') }}" method="POST" onsubmit="return confirm('เริ่มสำรองข้อมูลฐานข้อมูลและไฟล์?')" style="display:inline;">
                @csrf
                <button class="btn btn-warning">💾 Backup</button>
            </form>
            @if(count($backups) > 0)
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#restoreModal">♻️ Restore</button>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>จำนวนนักเรียน</h5>
                    <div class="display-6">{{ $studentCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>บุคลากร</h5>
                    <div class="display-6">{{ $teacherCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>ข้อเสนอแนะรอดำเนินการ</h5>
                    <div class="display-6">{{ $complaintCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <h5>Activity Log ล่าสุด</h5>
    <ul class="list-group">
        @foreach($logs as $log)
            <li class="list-group-item">[{{ $log->created_at->format('Y-m-d H:i') }}] {{ $log->description }}</li>
        @endforeach
    </ul>

    <!-- Restore Modal -->
    <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">♻️ Restore จากไฟล์ Backup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('backup.restore') }}" method="POST" onsubmit="return confirm('⚠️ คำเตือน: การ Restore จะแทนที่ข้อมูลปัจจุบัน คุณแน่ใจหรือไม่?')">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            <strong>⚠️ ข้อควรระวัง:</strong> การ Restore จะแทนที่ข้อมูลปัจจุบันทั้งหมด กรุณาเลือกไฟล์ให้ถูกต้อง
                        </div>
                        
                        <label class="form-label">เลือกไฟล์ Backup:</label>
                        <div class="list-group" role="group">
                            @forelse($backups as $backup)
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="backup_file" value="{{ $backup['filename'] }}" required>
                                    <strong>{{ $backup['filename'] }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        📅 {{ $backup['date'] }} | 📦 {{ $backup['size'] }}
                                    </small>
                                </label>
                            @empty
                                <p class="text-muted">ไม่มีไฟล์ Backup ให้เลือก</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-danger">♻️ Restore เลย</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
