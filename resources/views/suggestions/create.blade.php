<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งข้อเสนอแนะ - {{ config('app.name', 'Watpradu School') }}</title>
    
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
    <div class="container mx-auto px-4 py-12 max-w-2xl">
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">📝 แจ้งข้อเสนอแนะ</h2>
            <p class="text-gray-600">ส่งข้อเสนอแนะเพื่อช่วยพัฒนาโรงเรียนให้ดียิ่งขึ้น</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-4 rounded">
                <p class="font-semibold">✓ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('suggestions.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf

            <!-- Name Field -->
            <div class="mb-6">
                <label for="submitter_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    ชื่อ-สกุล <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="submitter_name" 
                    name="submitter_name"
                    value="{{ old('submitter_name') }}"
                    placeholder="กรุณากรอกชื่อ-สกุล"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('submitter_name') border-red-500 @enderror"
                    required
                >
                @error('submitter_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message Field -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                    ข้อเสนอแนะ <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="message" 
                    name="message"
                    rows="8"
                    placeholder="กรุณากรอกข้อเสนอแนะของท่าน (อย่างน้อย 10 ตัวอักษร)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none @error('message') border-red-500 @enderror"
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">ความยาว: <span id="char-count">0</span>/2000</p>
            </div>

            <!-- Info Box -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>💡 หมายเหตุ:</strong> ข้อเสนอแนะของท่านจะถูกส่งไปยังทีมบริหารโรงเรียน เพื่อพิจารณาและใช้ประโยชน์ในการพัฒนาคุณภาพการศึกษา
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300"
                >
                    ✓ ส่งข้อเสนอแนะ
                </button>
                <a 
                    href="/"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 text-center"
                >
                    ยกเลิก
                </a>
            </div>
        </form>

        <!-- Info Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">📞</div>
                <h4 class="font-bold text-lg mb-2">โทรศัพท์</h4>
                <p class="text-gray-600 text-sm">หลัก: 099-999-9999</p>
                <p class="text-gray-600 text-sm">สายตรง: 087-888-8888</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">✉️</div>
                <h4 class="font-bold text-lg mb-2">อีเมล</h4>
                <p class="text-gray-600 text-sm break-all">info@watpradu.ac.th</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl mb-3">📍</div>
                <h4 class="font-bold text-lg mb-2">ที่อยู่</h4>
                <p class="text-gray-600 text-sm">ตำบล อำเภอ จังหวัด</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 mt-16 border-t-4 border-purple-600">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2025 โรงเรียนวัดประดู่. All rights reserved.</p>
        </div>
    </footer>

    <!-- Character Counter Script -->
    <script>
        const messageInput = document.getElementById('message');
        const charCount = document.getElementById('char-count');
        
        messageInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    </script>

</body>
</html>
