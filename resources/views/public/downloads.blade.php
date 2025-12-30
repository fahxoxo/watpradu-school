@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">{{ $currentType }}</h1>
        <p class="text-gray-600">รวบรวมเอกสารและไฟล์ต่าง ๆ สำหรับดาวน์โหลด</p>
    </div>

    <!-- Downloads List -->
    @if($downloads->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ไม่มีเอกสารดาวน์โหลด</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($downloads as $item)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->filename }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $item->topic }}</p>

                        <!-- Download Button -->
                        <a href="{{ route('downloads.download', $item) }}" class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            ดาวน์โหลด
                        </a>

                        <!-- File Info -->
                        <div class="mt-4 pt-4 border-t border-gray-200 text-xs text-gray-500">
                            <p>📅 {{ $item->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Footer -->
<footer class="bg-blue-900 text-white mt-12">
    <div class="container mx-auto px-4 py-6 text-center">
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->school_name ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
