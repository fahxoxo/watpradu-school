<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $financial->topic }} - {{ config('app.name', 'Watpradu School') }}</title>
    
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
            <a href="{{ route('financial.public') }}" class="hover:text-green-600">ข้อมูลการเงิน</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $financial->topic }}</span>
        </div>

        <!-- Article Content -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Featured Image -->
            @if($financial->image)
                <div class="w-full mx-auto max-w-2xl" style="aspect-ratio: 210/297;">
                    <div class="w-full h-full bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $financial->image) }}" alt="{{ $financial->topic }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @else
                <div class="w-full mx-auto max-w-2xl bg-gradient-to-br from-green-300 to-green-600 flex items-center justify-center" style="aspect-ratio: 210/297;">
                    <div class="text-7xl">📊</div>
                </div>
            @endif

            <!-- Article Content -->
            <div class="p-8 md:p-12">
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $financial->topic }}</h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.757 4.243a.75.75 0 10-1.06 1.06A7.987 7.987 0 0112 4a7.987 7.987 0 017.303 3.303.75.75 0 10-1.06-1.06A6.487 6.487 0 0012 5.5a6.487 6.487 0 00-6.243 3.757zm0 11.514a.75.75 0 101.06 1.06A7.987 7.987 0 0112 20a7.987 7.987 0 01-7.303-3.303.75.75 0 101.06-1.06A6.487 6.487 0 0012 18.5a6.487 6.487 0 006.243-3.757zm4.486-9.004a.75.75 0 00-1.06 1.06L16.94 12l-3.757 3.757a.75.75 0 101.06 1.06L18 13.06l3.757 3.757a.75.75 0 101.06-1.06L19.06 12l3.757-3.757a.75.75 0 00-1.06-1.06L18 10.94l-3.757-3.757z" clip-rule="evenodd" /></svg>
                        {{ $financial->created_at->format('d M Y') }}
                    </div>
                </div>

                <!-- Description Body -->
                <div class="prose prose-lg max-w-none mb-8">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $financial->description }}
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Items -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">ข้อมูลการเงินอื่นๆ</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse(\App\Models\Financial::where('id', '!=', $financial->id)->orderBy('id', 'desc')->take(2)->get() as $relatedItem)
                    <a href="{{ route('financial.show', $relatedItem) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                        @if($relatedItem->image)
                            <div class="w-full h-48 overflow-hidden bg-gray-200">
                                <img src="{{ asset('storage/' . $relatedItem->image) }}" alt="{{ $relatedItem->topic }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-green-300 to-green-600 flex items-center justify-center">
                                <div class="text-5xl">📊</div>
                            </div>
                        @endif
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $relatedItem->created_at->format('d M Y') }}</p>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $relatedItem->topic }}</h4>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 col-span-2">ไม่มีข้อมูลการเงินอื่นๆ</p>
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
    <footer class="bg-gray-900 text-gray-300 py-8 mt-16 border-t-4 border-green-600">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2025 โรงเรียนวัดประดู่. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
