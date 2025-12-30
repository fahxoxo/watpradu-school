<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Watpradu Admin</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: #cfd8dc; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover, .sidebar a.active { background: #495057; color: white; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3" style="width: 280px;">
            <h4 class="text-center mb-4">Watpradu System</h4>
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <hr>
            <a href="{{ route('school-info.edit') }}">1. ข้อมูลโรงเรียน</a>
            <a href="{{ route('teachers.index') }}">2. ผู้บริหาร/บุคลากร</a>
            <a href="{{ route('posts.index') }}">3. ข่าวและกิจกรรม</a>
            <a href="{{ route('events.index') }}">4. ปฏิทินกิจกรรม</a>
            <a href="{{ route('galleries.index') }}">5. อัลบั้มภาพ</a>
            <a href="{{ route('student-stats.index') }}">6. ข้อมูลนักเรียน</a>
            <a href="{{ route('subjects.index') }}">7. ข้อมูลวิชาการ</a>
            <a href="{{ route('buildings.index') }}">8. อาคารสถานที่</a>
            <a href="{{ route('financials.index') }}">9. การเงิน</a>
            <a href="{{ route('downloads.index') }}">10. เอกสารดาวน์โหลด</a>
            <a href="{{ route('suggestions.index') }}">11. ข้อเสนอแนะ</a>
            
            <hr>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">ออกจากระบบ</button>
            </form>
        </div>

        <div class="flex-grow-1 p-4 bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>