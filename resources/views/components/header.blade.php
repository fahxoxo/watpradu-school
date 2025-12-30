<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Watpradu School') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    
    <style>
        .ticker-item { 
            display: none; 
            animation: fadeIn 0.5s ease-in-out;
        }
        .ticker-item.active { 
            display: block; 
        }
        @keyframes fadeIn { 
            from { opacity: 0; } 
            to { opacity: 1; } 
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- 1. PINNED TICKER -->
    <div class="bg-yellow-100 text-yellow-900 text-sm py-2 border-b border-yellow-200 sticky top-0 z-40">
        <div class="container mx-auto px-4 flex items-center gap-3">
            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded shrink-0 whitespace-nowrap">ประกาศด่วน</span>
            <div id="pinned-ticker" class="flex-1 overflow-hidden relative h-6">
                @if(isset($pinnedPosts) && count($pinnedPosts) > 0)
                    @foreach($pinnedPosts as $index => $post)
                        <div class="ticker-item absolute w-full truncate {{ $index === 0 ? 'active' : '' }}">
                            <a href="{{ route('posts.show', $post) }}" class="hover:underline font-medium text-yellow-900">📢 {{ $post->title }}</a>
                        </div>
                    @endforeach
                @else
                    <div class="ticker-item active absolute w-full text-yellow-900">📢 ยินดีต้อนรับสู่เว็บไซต์โรงเรียนวัดประดู่</div>
                    <div class="ticker-item absolute w-full text-yellow-900">📢 ติดตามข่าวสารและกิจกรรมล่าสุดได้ที่นี่</div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. HEADER & NAVIGATION -->
    <header class="bg-white shadow-md sticky top-16 z-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center py-4 gap-4">
                <!-- Logo Section -->
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                    @if(isset($schoolInfo) && $schoolInfo->logo)
                        <img src="{{ asset($schoolInfo->logo) }}" alt="School Logo" class="w-14 h-14 rounded-full object-cover shadow-lg">
                    @else
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            W
                        </div>
                    @endif
                    <div>
                        <h1 class="text-lg font-bold text-blue-900">{{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }}</h1>
                        <p class="text-xs text-gray-500">Watpradu School</p>
                    </div>
                </a>

                <!-- Navigation Menu -->
                <nav class="flex flex-wrap justify-center md:justify-end items-center gap-2 text-sm font-medium text-gray-700">
                    <a href="/" class="px-3 py-2 rounded hover:bg-blue-50 hover:text-blue-600 transition">หน้าหลัก</a>
                    
                    <!-- Dropdown: ข้อมูลพื้นฐาน -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-1">
                            ข้อมูลพื้นฐาน
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute left-0 top-full w-56 bg-white border border-gray-200 rounded shadow-lg hidden group-hover:block z-50">
                            <a href="/about" class="block px-4 py-2 hover:bg-blue-50 text-gray-700 border-b">ข้อมูลทั่วไป</a>
                            <a href="/motto" class="block px-4 py-2 hover:bg-blue-50 text-gray-700 border-b">วิสัยทัศน์/พันธกิจ</a>
                            <a href="/financial" class="block px-4 py-2 hover:bg-blue-50 text-gray-700 border-b">ข้อมูลการเงิน</a>
                            <a href="/teachers" class="block px-4 py-2 hover:bg-blue-50 text-gray-700 border-b">ข้อมูลบุคลากร</a>
                            <a href="{{ route('students.public') }}" class="block px-4 py-2 hover:bg-blue-50 text-gray-700 border-b">ข้อมูลนักเรียน</a>
                            <a href="{{ route('buildings.public') }}" class="block px-4 py-2 hover:bg-blue-50 text-gray-700">ข้อมูลอาคาร สถานที่</a>
                        </div>
                    </div>

                    <!-- Dropdown: ข่าว กิจกรรม -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded hover:bg-orange-50 hover:text-orange-600 transition flex items-center gap-1">
                            ข่าว กิจกรรม
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute left-0 top-full w-48 bg-white border border-gray-200 rounded shadow-lg hidden group-hover:block z-50">
                            <a href="{{ route('posts.news') }}" class="block px-4 py-2 hover:bg-orange-50 text-gray-700 border-b">ข่าวประชาสัมพันธ์</a>
                            <a href="{{ route('posts.activities') }}" class="block px-4 py-2 hover:bg-orange-50 text-gray-700 border-b">กิจกรรม</a>
                            <a href="{{ route('galleries.public') }}" class="block px-4 py-2 hover:bg-orange-50 text-gray-700">Gallery</a>
                        </div>
                    </div>

                    <!-- Dropdown: ดาวน์โหลด -->
                    <div class="relative group">
                        <button class="px-3 py-2 rounded hover:bg-green-50 hover:text-green-600 transition flex items-center gap-1">
                            ดาวน์โหลด
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute left-0 top-full w-48 bg-white border border-gray-200 rounded shadow-lg hidden group-hover:block z-50">
                            <a href="{{ route('downloads.public') }}" class="block px-4 py-2 hover:bg-green-50 text-gray-700 border-b">เอกสารดาวน์โหลด</a>
                            <a href="{{ route('downloads.type', 'calendar') }}" class="block px-4 py-2 hover:bg-green-50 text-gray-700 border-b">ปฏิทินการศึกษา</a>
                            <a href="{{ route('downloads.type', 'leave') }}" class="block px-4 py-2 hover:bg-green-50 text-gray-700 border-b">ใบลา</a>
                            <a href="{{ route('downloads.type', 'schedule') }}" class="block px-4 py-2 hover:bg-green-50 text-gray-700">ตารางสอน</a>
                        </div>
                    </div>

                    <a href="{{ route('suggestions.create') }}" class="px-3 py-2 rounded hover:bg-purple-50 hover:text-purple-600 transition">แจ้งข้อเสนอแนะ</a>

                    <!-- Search -->
                    <div class="relative hidden sm:block ml-2">
                        <form action="{{ route('posts.search') }}" method="GET" class="flex gap-1">
                            <input type="text" 
                                   name="q" 
                                   placeholder="ค้นหา..." 
                                   class="border border-gray-300 rounded-full pl-4 pr-10 py-2 text-sm w-40 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>
