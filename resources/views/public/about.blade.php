<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับเรา - {{ config('app.name', 'Watpradu School') }}</title>
    
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
        <!-- Breadcrumb -->
        <div class="mb-8 text-sm text-gray-600">
            <a href="/" class="hover:text-blue-600">หน้าหลัก</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">เกี่ยวกับเรา</span>
        </div>

        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Logo -->
                <div class="md:w-1/3 flex justify-center">
                    @if(isset($schoolInfo) && $schoolInfo->logo)
                        <img src="{{ asset($schoolInfo->logo) }}" alt="{{ $schoolInfo->schoolname }}" class="w-48 h-48 rounded-lg shadow-lg object-cover">
                    @else
                        <div class="w-48 h-48 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-lg flex items-center justify-center text-white text-6xl font-bold">W</div>
                    @endif
                </div>

                <!-- School Name & Basic Info -->
                <div class="md:w-2/3">
                    <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-4">
                        {{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }}
                    </h1>
                    
                    @if($schoolInfo->motto)
                        <p class="text-xl text-gray-600 mb-6 italic">
                            💭 {{ $schoolInfo->motto }}
                        </p>
                    @endif

                    <div class="space-y-3 text-gray-700">
                        @if($schoolInfo->address)
                            <p class="flex gap-2">
                                <span>📍</span>
                                <span>{{ $schoolInfo->address }}</span>
                            </p>
                        @endif
                        @if($schoolInfo->tel)
                            <p class="flex gap-2">
                                <span>📞</span>
                                <span>{{ $schoolInfo->tel }}</span>
                            </p>
                        @endif
                        @if($schoolInfo->email)
                            <p class="flex gap-2">
                                <span>✉️</span>
                                <span>{{ $schoolInfo->email }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Sections -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-3xl font-bold text-blue-900 mb-6 pb-4 border-b-4 border-blue-600">
                📖 ประวัติโรงเรียน
            </h2>
            
            @if($schoolInfo->history)
                <div class="text-gray-700 leading-relaxed space-y-4">
                    {!! nl2br(e($schoolInfo->history)) !!}
                </div>
            @else
                <div class="text-center py-12 text-gray-400">
                    <p>ยังไม่มีข้อมูลประวัติโรงเรียน</p>
                </div>
            @endif
        </div>

        <!-- Links to Other Pages -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a href="{{ route('motto') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-8 hover:shadow-xl transition text-center">
                <div class="text-4xl mb-3">🎯</div>
                <h3 class="text-2xl font-bold mb-2">วิสัยทัศน์ พันธกิจ</h3>
                <p class="text-blue-100">ดูวิสัยทัศน์ พันธกิจ และสัญญาประจำวัน</p>
            </a>
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
