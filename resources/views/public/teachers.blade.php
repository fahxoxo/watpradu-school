<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลบุคลากร - {{ config('app.name', 'Watpradu School') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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

    @include('components.header', ['pinnedPosts' => [], 'schoolInfo' => $schoolInfo])

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
<!-- Organizational Structure Map -->
    @if($schoolInfo && $schoolInfo->map_image)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📊 ผังโครงสร้างบุคลากร</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset($schoolInfo->map_image) }}" alt="ผังโครงสร้างบุคลากร" class="w-full h-auto">
        </div>
    </div>
    @endif


        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">👨‍🏫 ข้อมูลบุคลากร</h1>
            <p class="text-lg text-gray-600">รายชื่อครูอาจารย์และทีมงานของโรงเรียน</p>
        </div>

        <!-- Teachers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($teachers as $teacher)
                <a href="{{ route('teacher.show', $teacher) }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden group">
                    <!-- Teacher Image -->
                    <div class="h-64 bg-gray-200 overflow-hidden">
                        @if($teacher->image)
                            <img src="{{ asset($teacher->image) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <div class="text-6xl text-white font-bold">{{ substr($teacher->name, 0, 1) }}</div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Teacher Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                            {{ $teacher->name }}
                        </h3>
                        
                        @if($teacher->position)
                            <p class="text-blue-600 text-sm font-semibold mb-4">
                                📌 {{ $teacher->position }}
                            </p>
                        @endif
                        
                        <div class="pt-4 border-t border-gray-100">
                            @if($teacher->tel || $teacher->email)
                                <div class="flex items-center justify-between text-xs">
                                    @if($teacher->tel)
                                        <span class="text-gray-500">📞 {{ $teacher->tel }}</span>
                                    @endif
                                    @if($teacher->email)
                                        <span class="text-gray-500">✉️ {{ substr($teacher->email, 0, 15) }}...</span>
                                    @endif
                                </div>
                            @endif
                            <div class="mt-3">
                                <span class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                    ดูรายละเอียด →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">👥</div>
                    <p class="text-gray-500 text-lg">ยังไม่มีข้อมูลบุคลากร</p>
                </div>
            @endforelse
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 border-t border-gray-800 mt-16">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }} | สงวนสิทธิ์ทั้งหมด</p>
        </div>
    </footer>

</body>
</html>
