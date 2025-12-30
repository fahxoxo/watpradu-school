<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข่าวและกิจกรรม - {{ config('app.name', 'Watpradu School') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navigation Bar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold">W</div>
                    <div>
                        <h1 class="text-lg font-bold text-blue-900">โรงเรียนวัดประดู่</h1>
                    </div>
                </a>
                <a href="/" class="px-4 py-2 rounded hover:bg-blue-50 hover:text-blue-600 transition">← กลับหน้าหลัก</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-blue-900 mb-2">ข่าวและกิจกรรม</h1>
            <p class="text-gray-600">ติดตามข้อมูลข่าวประชาสัมพันธ์และกิจกรรมสำคัญของโรงเรียน</p>
            
            @if(request('tag'))
                <div class="mt-4">
                    <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                        แท็ก: <strong>{{ request('tag') }}</strong>
                        <a href="{{ route('posts.index') }}" class="ml-2 text-blue-600 hover:text-blue-800">✕</a>
                    </span>
                </div>
            @endif
        </div>

        <!-- Search Form -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
            <form method="GET" class="flex gap-4 flex-wrap">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="ค้นหาข่าวหรือกิจกรรม..." 
                    class="flex-1 min-w-xs px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    ค้นหา
                </button>
                @if(request('q') || request('tag'))
                    <a href="{{ route('posts.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
                        รีเซ็ต
                    </a>
                @endif
            </form>
        </div>

        <!-- Posts Grid -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            @endif
                            
                            <!-- Type Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $post->type === 'news' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $post->type === 'news' ? 'ข่าว' : 'กิจกรรม' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                {{ $post->title }}
                            </h3>
                            
                            <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>

                            <!-- Tags -->
                            @if($post->tags)
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach(array_filter(array_map('trim', explode(',', $post->tags))) as $tag)
                                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Date -->
                            <div class="text-xs text-gray-500 border-t pt-3">
                                {{ $post->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">ไม่พบข้อมูล</h3>
                <p class="text-gray-600 mb-6">ขออภัย ไม่พบข่าวหรือกิจกรรมที่คุณกำลังค้นหา</p>
                <a href="{{ route('posts.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    ดูข่าวทั้งหมด
                </a>
            </div>
        @endif
    </div>



    <!-- Back Button -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 border-t border-gray-800">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} โรงเรียนวัดประดู่ | สงวนสิทธิ์ทั้งหมด</p>
        </div>
    </footer>

</body>
</html>
