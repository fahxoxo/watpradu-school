@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>แก้ไขข้อมูลโรงเรียน</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('school-info.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">ชื่อโรงเรียน (schoolname)</label>
            <input type="text" name="schoolname" class="form-control" value="{{ old('schoolname', $info->schoolname ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">ประวัติ (history)</label>
            <textarea name="history" class="form-control" rows="4">{{ old('history', $info->history ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">คำขวัญ (motto)</label>
                <input type="text" name="motto" class="form-control" value="{{ old('motto', $info->motto ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">วิสัยทัศน์ (vision)</label>
                <input type="text" name="vision" class="form-control" value="{{ old('vision', $info->vision ?? '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">พันธกิจ (mission)</label>
            <textarea name="mission" class="form-control" rows="3">{{ old('mission', $info->mission ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">เบอร์โทร (tel)</label>
                <input type="text" name="tel" class="form-control" value="{{ old('tel', $info->tel ?? '') }}">
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">อีเมล (email)</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $info->email ?? '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">ที่อยู่ (address)</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $info->address ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">โลโก้ (logo)</label>
                @if(!empty($info->logo))
                    <div class="mb-2"><img src="{{ asset($info->logo) }}" alt="Logo" style="max-height:80px;"></div>
                @endif
                <input type="file" name="logo" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">สกรีน (screen)</label>
                @if(!empty($info->screen))
                    <div class="mb-2"><img src="{{ asset($info->screen) }}" alt="Screen" style="max-height:80px; width:auto"></div>
                @endif
                <input type="file" name="screen" class="form-control">
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">บันทึก</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection
