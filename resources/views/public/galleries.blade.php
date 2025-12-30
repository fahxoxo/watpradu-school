@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Gallery</h1>
        <p class="text-gray-600">ดูอัลบั้มรูปภาพและกิจกรรมต่างๆ ของโรงเรียน</p>
    </div>

    <!-- Galleries Grid -->
    @if($galleries->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ยังไม่มีอัลบั้มรูปภาพ</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
                <a href="{{ route('galleries.public.show', $gallery->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer transform hover:scale-105">
                        <!-- Gallery Cover Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($gallery->images->count() > 0)
                                @php
                                    $firstImage = $gallery->images->first();
                                @endphp
                                <img src="{{ $firstImage->thumb_url ?? asset($firstImage->file_path) }}" 
                                     alt="{{ $gallery->activity_name }}" 
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-indigo-200">
                                    <svg class="w-20 h-20 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Gallery Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $gallery->activity_name }}</h3>
                            <div class="text-sm text-gray-500 mb-3">
                                <p>🖼️ จำนวนรูป: {{ $gallery->images_count }} รูป</p>
                            </div>
                            <div class="text-sm text-gray-500 mb-3">
                                <p>📅 {{ $gallery->created_at->locale('th')->format('d F Y') }}</p>
                            </div>
                        </div>

                        <!-- Arrow Indicator -->
                        <div class="px-6 pb-4">
                            <div class="inline-flex items-center text-blue-600 font-semibold text-sm hover:text-blue-800">
                                ดูรูปภาพ
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
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
<footer class="bg-blue-900 text-white mt-12">
    <div class="container mx-auto px-4 py-6 text-center">
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->schoolname ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
