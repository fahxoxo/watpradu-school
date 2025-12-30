@extends('layouts.admin')

@section('content')
<h3>อัลบั้ม: {{ $gallery->activity_name }}</h3>

<div class="mb-3">
    <a href="{{ route('galleries.index') }}" class="btn btn-secondary">กลับรายการ</a>
</div>

@if($gallery->images->isEmpty())
    <div class="alert alert-info">ยังไม่มีรูปภาพในอัลบั้มนี้</div>
@else
<div class="row">
    @foreach($gallery->images as $img)
    <div class="col-md-3 mb-3">
        <div class="card">
            @if($img->thumb_url)
            <a href="{{ $img->url }}" target="_blank">
                <img src="{{ $img->thumb_url }}" class="card-img-top" style="height:200px;object-fit:cover">
            </a>
            @elseif($img->file_path)
            <img src="{{ asset($img->file_path) }}" class="card-img-top" style="height:200px;object-fit:cover">
            @endif
            <div class="card-body p-2">
                <div class="small">{{ $img->filename }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection