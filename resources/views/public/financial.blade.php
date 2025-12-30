<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลการเงิน - {{ config('app.name', 'Watpradu School') }}</title>
    
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
    <div class="container mx-auto px-4 py-12">
        

        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">💰 ข้อมูลการเงิน</h1>
            <p class="text-lg text-gray-600">ความโปร่งใสในการบริหารการเงินของโรงเรียน</p>
        </div>

        <!-- Financial Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($items as $item)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden group">
                    <!-- Item Image -->
                    @if($item->image)
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->topic }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <div class="text-5xl">📊</div>
                        </div>
                    @endif
                    
                    <!-- Item Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-green-600 transition">
                            {{ $item->topic }}
                        </h3>
                        
                        @if($item->description)
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                {{ Str::limit($item->description, 150) }}
                            </p>
                        @endif
                        
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                📅 {{ $item->created_at->format('d M Y') }}
                            </span>
                            <a href="{{ route('financial.show', $item) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                ดูรายละเอียด →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-5xl mb-4">📄</div>
                    <p class="text-gray-600 text-lg">ยังไม่มีข้อมูลการเงิน</p>
                </div>
            @endforelse
        </div>

        <!-- Info Section -->
        <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-8 mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">📋 ข้อมูลเพิ่มเติม</h3>
            <p class="text-gray-700 mb-4">
                โรงเรียนวัดประดู่มุ่งมั่นในการบริหารการเงินอย่างโปร่งใส และรับผิดชอบต่อผู้ปกครอง 
                รวมถึงหน่วยงานที่เกี่ยวข้อง บนพื้นฐานของหลักธรรมาภิบาล
            </p>
            <p class="text-gray-700">
                หากมีข้อสงสัยเกี่ยวกับข้อมูลการเงิน สามารถติดต่อหน่วยงานการเงินของโรงเรียนได้
            </p>
        </div>

        <!-- Back Button -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>

        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">📞</div>
                <h4 class="font-bold text-lg mb-2">โทรศัพท์</h4>
                <p class="text-gray-600 text-sm">หลัก: 099-999-9999</p>
                <p class="text-gray-600 text-sm">สายตรง: 087-888-8888</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">✉️</div>
                <h4 class="font-bold text-lg mb-2">อีเมล</h4>
                <p class="text-gray-600 text-sm break-all">finance@watpradu.ac.th</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">📍</div>
                <h4 class="font-bold text-lg mb-2">ที่อยู่</h4>
                <p class="text-gray-600 text-sm">ตำบล อำเภอ จังหวัด</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 mt-16 border-t-4 border-green-600">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2025 โรงเรียนวัดประดู่. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
