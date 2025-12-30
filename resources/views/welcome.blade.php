@include('components.header', ['pinnedPosts' => $pinnedPosts, 'schoolInfo' => $schoolInfo])

    <!-- Custom CSS for FullCalendar -->
    <style>
        .fc-event-time {
            display: none !important;
        }
    </style>

    <!-- 3. HERO SECTION -->
    <section class="relative w-full h-96 md:h-[500px] lg:h-[600px] bg-gray-900 overflow-hidden">
        @if(isset($schoolInfo) && $schoolInfo->screen)
            <img src="{{ $schoolInfo->screen }}" alt="School" class="w-full h-full object-cover opacity-70">
        @else
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="School" class="w-full h-full object-cover opacity-70">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent flex flex-col justify-end p-6 md:p-12 lg:p-16">
            <div class="container mx-auto">
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg">ยินดีต้อนรับสู่รั้วโรงเรียน</h2>
                <p class="text-gray-200 text-base md:text-lg max-w-2xl drop-shadow-md">มุ่งมั่นพัฒนาวิชาการ สืบสานวัฒนธรรม นำเทคโนโลยี</p>
            </div>
        </div>
    </section>

    <!-- 4. NEWS & ACTIVITIES SECTION -->
    <section class="py-12 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                
                <!-- News -->
                <div>
                    <div class="flex justify-between items-end mb-6 border-b-2 border-blue-200 pb-3">
                        <h3 class="text-2xl md:text-3xl font-bold text-blue-900">ข่าวประชาสัมพันธ์</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">ดูทั้งหมด →</a>
                    </div>
                    
                    <div class="space-y-5">
                        @if(isset($latestNews) && $latestNews->count() > 0)
                            @foreach($latestNews as $news)
                                <a href="{{ route('posts.show', $news) }}" class="block bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition border border-gray-100 flex flex-col sm:flex-row gap-4 p-4 group">
                                    <div class="w-full sm:w-32 h-32 bg-gray-300 rounded overflow-hidden flex-shrink-0">
                                        @if($news->image)
                                            <img src="{{ asset('storage/'.$news->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" alt="{{ $news->title }}">
                                        @else
                                            <div class="w-full h-full bg-gray-400"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">ข่าว</span>
                                        <h4 class="font-bold text-gray-900 text-base mt-2 line-clamp-2 group-hover:text-blue-600 transition">{{ $news->title }}</h4>
                                        <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ Str::limit(strip_tags($news->content), 80) }}</p>
                                        <time class="text-xs text-gray-500 mt-2">{{ $news->created_at->format('d M Y') }}</time>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center py-10 bg-gray-50 rounded border border-dashed text-gray-500">
                                <p>ยังไม่มีข่าวประชาสัมพันธ์</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Activities -->
                <div>
                    <div class="flex justify-between items-end mb-6 border-b-2 border-orange-200 pb-3">
                        <h3 class="text-2xl md:text-3xl font-bold text-orange-900">กิจกรรมล่าสุด</h3>
                        <a href="#" class="text-sm text-orange-600 hover:text-orange-800 font-semibold">ดูทั้งหมด →</a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if(isset($latestActivities) && $latestActivities->count() > 0)
                            @foreach($latestActivities as $activity)
                                <a href="{{ route('posts.show', $activity) }}" class="bg-white rounded-lg shadow-sm hover:shadow-md transition border border-gray-100 overflow-hidden block group">
                                    <div class="h-40 bg-gray-300 relative overflow-hidden">
                                        @if($activity->image)
                                            <img src="{{ asset('storage/'.$activity->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" alt="{{ $activity->title }}">
                                        @else
                                            <div class="w-full h-full bg-gray-400"></div>
                                        @endif
                                        <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            {{ $activity->created_at->format('d M') }}
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-bold text-gray-900 text-sm line-clamp-2 group-hover:text-orange-600 transition">{{ $activity->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-2">👁 320 ครั้ง</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="col-span-full text-center py-10 bg-gray-50 rounded border border-dashed text-gray-500">
                                <p>ยังไม่มีกิจกรรมล่าสุด</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. CALENDAR SECTION -->
    <section class="py-12 md:py-16 bg-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h3 class="text-2xl md:text-3xl font-bold text-blue-900 inline-block pb-3 border-b-4 border-blue-600">
                    ปฏิทินกิจกรรม
                </h3>
                <p class="text-gray-600 mt-4">ติดตามกำหนดการและกิจกรรมสำคัญของโรงเรียน</p>
            </div>
            
            <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 p-6 md:p-8">
                <div id="public-calendar"></div>
            </div>
        </div>
    </section>

    <!-- 6. FOOTER -->
    <footer class="bg-gray-900 text-gray-300 py-12 border-t-4 border-blue-600">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- School Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        @if(isset($schoolInfo) && $schoolInfo->logo)
                            <img src="{{ asset($schoolInfo->logo) }}" alt="School Logo" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-900 font-bold text-lg">W</div>
                        @endif
                        <div>
                            <h4 class="text-lg font-bold text-white">{{ $schoolInfo->schoolname ?? 'โรงเรียนวัดประดู่' }}</h4>
                            <p class="text-xs text-gray-400">Watpradu School</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400">
                        มุ่งมั่นพัฒนาผู้เรียนให้มีความรู้คู่คุณธรรม นำสมัยด้วยเทคโนโลยี สืบสานวัฒนธรรมไทย
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">ติดต่อเรา</h4>
                    <ul class="space-y-3 text-sm mt-3">
                        <li class="flex gap-2">
                            <span>📍</span>
                            <span>123 หมู่ 1 ต.วัดประดู่ อ.เมือง จ.สุราษฎร์ธานี 84000</span>
                        </li>
                        <li class="flex gap-2">
                            <span>📞</span>
                            <span>077-123-456</span>
                        </li>
                        <li class="flex gap-2">
                            <span>✉️</span>
                            <span>contact@watpradu.ac.th</span>
                        </li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">ติดตามเรา</h4>
                    <div class="flex gap-3 mt-4 mb-6">
                        <a href="https://www.facebook.com/pradoosongtham" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition">f</a>
                        <a href="#" class="w-10 h-10 bg-sky-500 rounded-full flex items-center justify-center text-white hover:bg-sky-600 transition">𝕏</a>
                        <a href="#" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition">▶</a>
                    </div>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition">ระบบรับสมัครนักเรียน</a></li>
                        <li><a href="#" class="hover:text-white transition">ระบบดูแลช่วยเหลือนักเรียน</a></li>
                        <li><a href="/login" class="hover:text-white transition">เข้าสู่ระบบบุคลากร</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-6 text-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} โรงเรียนวัดประดู่ | สงวนสิทธิ์ทั้งหมด</p>
            </div>
        </div>
    </footer>

    <!-- FullCalendar Script -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calendar
        const calEl = document.getElementById('public-calendar');
        if (calEl) {
            const calendar = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                height: 'auto',
                contentHeight: 'auto',
                events: '{{ route('events.public.json') }}',
                editable: false,
                eventDisplay: 'block'
            });
            calendar.render();
        }

        // Ticker
        const items = document.querySelectorAll('.ticker-item');
        if (items.length > 1) {
            let idx = 0;
            setInterval(() => {
                items[idx].classList.remove('active');
                idx = (idx + 1) % items.length;
                items[idx].classList.add('active');
            }, 5000);
        }
    });
    </script>
</body>
</html>
