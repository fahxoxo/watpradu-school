@extends('layouts.admin')

@section('content')
<h3>แก้ไขข่าว/กิจกรรม - {{ $post->title }}</h3>

<form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">ชื่อหัวข้อ</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        @error('title')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">เนื้อหา</label>
        <textarea name="content" class="form-control" rows="6">{{ old('content', $post->content) }}</textarea>
        @error('content')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">รูปภาพ (อัปโหลดเพื่อแทนที่)</label>
        @if($post->image)
            <div class="mb-2"><img src="{{ asset('storage/'.$post->image) }}" style="max-width:200px; max-height:140px; object-fit:cover;"></div>
        @endif
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">แท็ก / คำสำคัญ (คั่นด้วย comma)</label>
        <input type="text" name="tags" class="form-control" value="{{ old('tags', $post->tags) }}">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">ประเภท</label>
            <select name="type" class="form-control" required>
                <option value="news" {{ $post->type=='news' ? 'selected' : '' }}>ข่าว</option>
                <option value="activity" {{ $post->type=='activity' ? 'selected' : '' }}>กิจกรรม</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">ปักหมุด</label>
            <select name="pinned" class="form-control">
                <option value="unpinned" {{ !$post->pinned ? 'selected' : '' }}>ไม่ปักหมุด</option>
                <option value="pinned" {{ $post->pinned ? 'selected' : '' }}>ปักหมุด</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">อัพเดต</button>
        <a href="{{ route('posts.admin.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection