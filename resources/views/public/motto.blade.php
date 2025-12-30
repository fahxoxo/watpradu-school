<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิสัยทัศน์ พันธกิจ - {{ config('app.name', 'Watpradu School') }}</title>
    
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <!-- Breadcrumb -->
        <div class="mb-8 text-sm text-gray-600">
            <a href="/" class="hover:text-blue-600">หน้าหลัก</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">วิสัยทัศน์ พันธกิจ</span>
        </div>

        <!-- Header -->
        <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-12 text-center">
            วิสัยทัศน์ พันธกิจ และสัญญาประจำวัน
        </h1>

        <!-- Vision, Mission, Motto Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Vision Card -->
            @if($schoolInfo->vision)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition overflow-hidden">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8">
                        <div class="text-5xl mb-3">🎯</div>
                        <h2 class="text-2xl font-bold">วิสัยทัศน์</h2>
                    </div>
                    <div class="p-8">
                        <p class="text-lg text-gray-700 leading-relaxed">
                            {{ $schoolInfo->vision }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Mission Card -->
            @if($schoolInfo->mission)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition overflow-hidden">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-8">
                        <div class="text-5xl mb-3">🚀</div>
                        <h2 class="text-2xl font-bold">พันธกิจ</h2>
                    </div>
                    <div class="p-8">
                        <p class="text-lg text-gray-700 leading-relaxed">
                            {{ $schoolInfo->mission }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Motto Card -->
            @if($schoolInfo->motto)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition overflow-hidden">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-8">
                        <div class="text-5xl mb-3">✨</div>
                        <h2 class="text-2xl font-bold">สัญญาประจำวัน</h2>
                    </div>
                    <div class="p-8">
                        <p class="text-2xl text-gray-700 leading-relaxed font-semibold text-center italic">
                            "{{ $schoolInfo->motto }}"
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Detailed Explanation Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-3xl font-bold text-blue-900 mb-8 pb-4 border-b-4 border-blue-600">
                📚 รายละเอียด
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Vision Explanation -->
                @if($schoolInfo->vision)
                    <div>
                        <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <span class="text-3xl">🎯</span>
                            <span>วิสัยทัศน์คืออะไร?</span>
                        </h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            วิสัยทัศน์ คือเป้าหมายแบบยาวระยะของโรงเรียน ซึ่งแสดงให้เห็นว่าเราต้องการนำโรงเรียนไปสู่จุดไหนในอนาคต
                        </p>
                        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded">
                            <p class="text-gray-800 font-semibold">{{ $schoolInfo->vision }}</p>
                        </div>
                    </div>
                @endif

                <!-- Mission Explanation -->
                @if($schoolInfo->mission)
                    <div>
                        <h3 class="text-xl font-bold text-orange-900 mb-4 flex items-center gap-2">
                            <span class="text-3xl">🚀</span>
                            <span>พันธกิจคืออะไร?</span>
                        </h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            พันธกิจ คือภารกิจ หรือความรับผิดชอบหลักของโรงเรียน ที่บอกว่าเราจะทำอะไรเพื่อให้ถึงวิสัยทัศน์
                        </p>
                        <div class="bg-orange-50 border-l-4 border-orange-600 p-4 rounded">
                            <p class="text-gray-800 font-semibold">{{ $schoolInfo->mission }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Motto Explanation -->
            @if($schoolInfo->motto)
                <div class="mt-8 pt-8 border-t-2 border-gray-200">
                    <h3 class="text-xl font-bold text-green-900 mb-4 flex items-center gap-2">
                        <span class="text-3xl">✨</span>
                        <span>สัญญาประจำวัน</span>
                    </h3>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        สัญญาประจำวัน คือข้อปฏิญาณ หรือคำพูดที่กำหนดค่านิยมและจริยธรรมของโรงเรียน ที่นักเรียนและบุคลากรต้องยึดถือในแต่ละวัน
                    </p>
                    <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded text-center">
                        <p class="text-3xl text-gray-800 font-bold italic">
                            "{{ $schoolInfo->motto }}"
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="/" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                ← กลับหน้าหลัก
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 border-t border-gray-800 mt-16">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }} | สงวนสิทธิ์ทั้งหมด</p>
        </div>
    </footer>

</body>
</html>
