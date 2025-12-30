<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $teacher->name ?? 'ครูอาจารย์' }} - {{ config('app.name', 'Watpradu School') }}</title>
    
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
            <span class="text-gray-800 font-medium">{{ $teacher->name }}</span>
        </div>

        <!-- Back Button -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>

        <!-- Teacher Profile -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="flex flex-col md:flex-row">
                <!-- Teacher Image -->
                <div class="md:w-1/3 flex items-center justify-center p-8 bg-gradient-to-br from-blue-50 to-gray-100">
                    @if($teacher->image)
                        <img src="{{ asset($teacher->image) }}" alt="{{ $teacher->name }}" class="w-64 h-64 rounded-lg shadow-lg object-cover">
                    @else
                        <div class="w-64 h-64 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-lg flex items-center justify-center text-white text-6xl font-bold">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Teacher Info -->
                <div class="md:w-2/3 p-8">
                    <h1 class="text-4xl font-bold text-blue-900 mb-2">{{ $teacher->name }}</h1>
                    
                    @if($teacher->position)
                        <p class="text-xl text-blue-600 font-semibold mb-6">
                            📌 {{ $teacher->position }}
                        </p>
                    @endif

                    <div class="space-y-4 text-gray-700">
                        @if($teacher->tel)
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📞</span>
                                <div>
                                    <p class="text-sm text-gray-500">เบอร์ติดต่อ</p>
                                    <p class="font-semibold">{{ $teacher->tel }}</p>
                                </div>
                            </div>
                        @endif

                        @if($teacher->email)
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">✉️</span>
                                <div>
                                    <p class="text-sm text-gray-500">อีเมล</p>
                                    <p class="font-semibold"><a href="mailto:{{ $teacher->email }}" class="text-blue-600 hover:text-blue-800">{{ $teacher->email }}</a></p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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


    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 border-t border-gray-800 mt-16">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }} | สงวนสิทธิ์ทั้งหมด</p>
        </div>
    </footer>

</body>
</html>
