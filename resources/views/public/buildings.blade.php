@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">ข้อมูลอาคาร สถานที่</h1>
        <p class="text-gray-600">อาคารสถานที่และสิ่งก่อสร้างของโรงเรียน</p>
    </div>

    <!-- Buildings Grid -->
    @if($buildings->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ยังไม่มีข้อมูลอาคาร สถานที่</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($buildings as $building)
                <a href="{{ route('buildings.show', $building->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer transform hover:scale-105">
                        <!-- Building Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($building->image)
                                <img src="{{ $building->image_url }}" alt="{{ $building->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                    <svg class="w-20 h-20 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Building Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $building->name }}</h3>
                            <div class="text-sm text-gray-500">
                                <p>📅 สร้างเมื่อ: {{ $building->created_at->format('d/m/Y') }}</p>
                            </div>
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
    @endif
</div>

<!-- Footer -->
<footer class="bg-blue-900 text-white mt-12">
    <div class="container mx-auto px-4 py-6 text-center">
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->schoolname ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
