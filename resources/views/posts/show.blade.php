<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - {{ config('app.name', 'Watpradu School') }}</title>
    
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
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-gray-600">
            <a href="/" class="hover:text-blue-600">หน้าหลัก</a>
            <span class="mx-2">/</span>
            <span>{{ $post->type === 'news' ? 'ข่าวประชาสัมพันธ์' : 'กิจกรรม' }}</span>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $post->title }}</span>
        </div>

        <!-- Article Header -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Featured Image -->
            @if($post->image)
                <div class="w-full h-96 overflow-hidden bg-gray-200">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Article Content -->
            <div class="p-8 md:p-12">
                <!-- Type Badge -->
                <div class="mb-4">
                    @if($post->type === 'news')
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">ข่าวประชาสัมพันธ์</span>
                    @else
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded-full">กิจกรรม</span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.757 4.243a.75.75 0 10-1.06 1.06A7.987 7.987 0 0112 4a7.987 7.987 0 017.303 3.303.75.75 0 10-1.06-1.06A6.487 6.487 0 0012 5.5a6.487 6.487 0 00-6.243 3.757zm0 11.514a.75.75 0 101.06 1.06A7.987 7.987 0 0112 20a7.987 7.987 0 01-7.303-3.303.75.75 0 101.06-1.06A6.487 6.487 0 0012 18.5a6.487 6.487 0 006.243-3.757zm4.486-9.004a.75.75 0 00-1.06 1.06L16.94 12l-3.757 3.757a.75.75 0 101.06 1.06L18 13.06l3.757 3.757a.75.75 0 101.06-1.06L19.06 12l3.757-3.757a.75.75 0 00-1.06-1.06L18 10.94l-3.757-3.757z" clip-rule="evenodd" /></svg>
                        {{ $post->created_at->format('d M Y') }}
                    </div>
                    @if($post->tags)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1 4.5 4.5 0 11-4.814 4.98z" clip-rule="evenodd"/></svg>
                            {{ $post->tags }}
                        </div>
                    @endif
                </div>

                <!-- Article Body -->
                <div class="prose prose-lg max-w-none mb-8">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $post->content }}
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Posts -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $post->type === 'news' ? 'ข่าวอื่นๆ' : 'กิจกรรมอื่นๆ' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($post->type === 'news' ? \App\Models\Post::where('type', 'news')->where('active', true)->where('id', '!=', $post->id)->latest()->take(2)->get() : \App\Models\Post::where('type', 'activity')->where('active', true)->where('id', '!=', $post->id)->latest()->take(2)->get() as $relatedPost)
                    <a href="{{ route('posts.show', $relatedPost) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                        @if($relatedPost->image)
                            <div class="w-full h-48 overflow-hidden bg-gray-200">
                                <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-300 to-gray-400"></div>
                        @endif
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $relatedPost->created_at->format('d M Y') }}</p>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition line-clamp-2">{{ $relatedPost->title }}</h4>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 col-span-2">ไม่มีข่าวหรือกิจกรรมอื่นๆ</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Back Button -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>


    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 mt-16 border-t-4 border-blue-600">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2025 โรงเรียนวัดประดู่. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
