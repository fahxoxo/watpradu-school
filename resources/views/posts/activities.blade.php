@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">กิจกรรม</h1>
        <p class="text-gray-600">ติดตามกิจกรรมล่าสุดจากโรงเรียนวัดประดู่</p>
    </div>

    <!-- Activities Grid -->
    @if($posts->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ยังไม่มีกิจกรรม</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer transform hover:scale-105">
                        <!-- Post Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-purple-200">
                                    <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($post->pinned)
                                <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    📌 ปักหมุด
                                </div>
                            @endif
                        </div>

                        <!-- Post Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $post->title }}</h3>
                            <div class="text-sm text-gray-500 mb-3">
                                <p>📅 {{ $post->created_at->locale('th')->format('d F Y') }}</p>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ strip_tags($post->content) }}
                            </p>
                            @if($post->tags)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach(array_slice(explode(',', $post->tags), 0, 2) as $tag)
                                        <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Arrow Indicator -->
                        <div class="px-6 pb-4">
                            <div class="inline-flex items-center text-blue-600 font-semibold text-sm hover:text-blue-800">
                                ดูรายละเอียด
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Back Button -->
<div class="text-center mb-8">
    <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
        ← กลับหน้าหลัก
    </a>
</div>

<!-- Footer -->
<footer class="bg-blue-900 text-white mt-12">
    <div class="container mx-auto px-4 py-6 text-center">
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->schoolname ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
