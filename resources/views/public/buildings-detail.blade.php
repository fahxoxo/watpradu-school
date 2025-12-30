@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('buildings.public') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            กลับไป
        </a>
    </div>

    <!-- Building Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <!-- Building Image -->
        <div class="w-full bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
            @if($building->image)
                <img src="{{ $building->image_url }}" alt="{{ $building->name }}" class="w-full h-auto object-contain max-h-[600px]">
            @else
                <div class="w-full h-96 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                    <svg class="w-32 h-32 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Building Info -->
        <div class="p-8">
            <h1 class="text-4xl font-bold text-blue-900 mb-4">{{ $building->name }}</h1>
            
            <div class="grid grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <p class="text-gray-600 text-sm mb-1">สร้างเมื่อ</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $building->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm mb-1">อัพเดตล่าสุด</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $building->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Buildings -->
    @if($relatedBuildings->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">อาคารอื่นๆ</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($relatedBuildings as $related)
                <a href="{{ route('buildings.show', $related->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer">
                        <!-- Image -->
                        <div class="relative w-full h-32 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($related->image)
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Name -->
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-800 truncate text-sm">{{ $related->name }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
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
