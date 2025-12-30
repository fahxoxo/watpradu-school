@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Breadcrumb & Back Button -->
    <div class="mb-6">
        <div class="text-sm text-gray-600 mb-4">
            <a href="/" class="hover:text-blue-600">หน้าหลัก</a>
            <span class="mx-2">/</span>
            <a href="{{ route('galleries.public') }}" class="hover:text-blue-600">Gallery</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $gallery->activity_name }}</span>
        </div>
        <a href="{{ route('galleries.public') }}" class="inline-block text-blue-600 hover:text-blue-800 font-semibold">
            ← กลับ Gallery
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">{{ $gallery->activity_name }}</h1>
        <p class="text-gray-600">📅 {{ $gallery->created_at->locale('th')->format('d F Y') }} • 🖼️ {{ $gallery->images->count() }} รูป</p>
    </div>

    <!-- Gallery Images -->
    @if($gallery->images->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ยังไม่มีรูปภาพในอัลบั้มนี้</p>
        </div>
    @else
        <!-- Image Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($gallery->images as $img)
                <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <a href="{{ $img->url ?? asset($img->file_path) }}" data-lightbox="gallery" data-title="{{ $gallery->activity_name }}">
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            <img src="{{ $img->thumb_url ?? asset($img->file_path) }}" 
                                 alt="{{ $gallery->activity_name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 cursor-pointer">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 12a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Lightbox Script -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
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
