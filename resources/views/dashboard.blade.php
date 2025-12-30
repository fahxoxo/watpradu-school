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
        <form action="{{ route('backup.run') }}" method="POST" onsubmit="return confirm('เริ่มสำรองข้อมูลฐานข้อมูลและไฟล์?')">
            @csrf
            <button class="btn btn-warning">เริ่ม Backup</button>
        </form>
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
</div>
@endsection
