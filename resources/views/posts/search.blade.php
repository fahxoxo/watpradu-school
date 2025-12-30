@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">ผลการค้นหา</h1>
        <p class="text-gray-600">ค้นหาคำว่า: <strong>"{{ $query }}"</strong></p>
    </div>

    <!-- Search Form -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
        <form method="GET" action="{{ route('posts.search') }}" class="flex gap-2">
            <input type="text" 
                   name="q" 
                   value="{{ $query }}" 
                   placeholder="ค้นหาข่าว กิจกรรม..." 
                   class="flex-1 border border-gray-300 rounded-lg pl-4 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ค้นหา
            </button>
        </form>
    </div>

    <!-- Search Results -->
    @if(!empty($query))
        @if($posts->count() > 0)
            <div class="mb-6">
                <p class="text-gray-600">พบ <strong>{{ $posts->total() }}</strong> ผลลัพธ์</p>
            </div>

            <div class="space-y-4 mb-8">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->id) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 group">
                        <div class="flex gap-4">
                            <!-- Image -->
                            <div class="hidden sm:block w-24 h-24 flex-shrink-0">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-full object-cover rounded group-hover:scale-110 transition">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 rounded flex items-center justify-center">
                                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex gap-2 mb-2">
                                    @if($post->type === 'news')
                                        <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded">ข่าว</span>
                                    @elseif($post->type === 'activity')
                                        <span class="text-xs font-bold bg-orange-100 text-orange-700 px-2 py-1 rounded">กิจกรรม</span>
                                    @endif
                                    @if($post->pinned)
                                        <span class="text-xs font-bold bg-red-100 text-red-700 px-2 py-1 rounded">📌 ปักหมุด</span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600">
                                    {{ $post->title }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ strip_tags($post->content) }}
                                </p>

                                <div class="flex gap-3 text-sm text-gray-500">
                                    <span>📅 {{ $post->created_at->locale('th')->format('d F Y') }}</span>
                                    @if($post->tags)
                                        <span>🏷️ {{ implode(', ', array_slice(explode(',', $post->tags), 0, 2)) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="flex justify-center mt-12">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">ไม่พบผลลัพธ์</h3>
                <p class="text-gray-500">ไม่พบข่าวหรือกิจกรรมที่ตรงกับคำค้นหา "{{ $query }}"</p>
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">กรุณากรอกคำค้นหา</h3>
            <p class="text-gray-500">ใช้ช่องค้นหาข้างบนเพื่อค้นหาข่าวและกิจกรรม</p>
        </div>
    @endif
</div>

<!-- Footer -->
<footer class="bg-blue-900 text-white mt-12">
    <div class="container mx-auto px-4 py-6 text-center">
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->schoolname ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
