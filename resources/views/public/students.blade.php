@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">ข้อมูลสถิติ นักเรียน</h1>
        <p class="text-gray-600">สรุปข้อมูลสถิติ นักเรียนในแต่ละปีการศึกษา</p>
    </div>

    <!-- Student Stats List -->
    @if($stats->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">ยังไม่มีข้อมูลสถิติ นักเรียน</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($stats as $stat)
                <a href="{{ route('students.detail', $stat->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer transform hover:scale-105">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                            <h3 class="text-2xl font-bold">{{ $stat->academic_year }}</h3>
                            <p class="text-blue-100 text-sm">ปีการศึกษา</p>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <p class="text-gray-600 text-sm mb-1">นักเรียนชาย</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ $stat->count_male }}</p>
                                </div>
                                <div class="bg-pink-50 rounded-lg p-4">
                                    <p class="text-gray-600 text-sm mb-1">นักเรียนหญิง</p>
                                    <p class="text-3xl font-bold text-pink-600">{{ $stat->count_female }}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 col-span-2">
                                    <p class="text-gray-600 text-sm mb-1">รวมทั้งสิ้น</p>
                                    <p class="text-3xl font-bold text-green-600">{{ $stat->total_students }}</p>
                                </div>
                            </div>

                            <!-- Brief Grade Summary -->
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-gray-600 text-sm font-semibold mb-3">สรุปจำนวนนักเรียนตามชั้นปี</p>
                                <div class="grid grid-cols-3 gap-2 text-xs">
                                    <div class="text-center">
                                        <p class="text-gray-500">อนุบาล</p>
                                        <p class="font-bold text-blue-600">{{ $stat->grade_k1_boys + $stat->grade_k1_girls + $stat->grade_k2_boys + $stat->grade_k2_girls + $stat->grade_k3_boys + $stat->grade_k3_girls }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-500">ประถม</p>
                                        <p class="font-bold text-green-600">{{ $stat->grade_p1_boys + $stat->grade_p1_girls + $stat->grade_p2_boys + $stat->grade_p2_girls + $stat->grade_p3_boys + $stat->grade_p3_girls + $stat->grade_p4_boys + $stat->grade_p4_girls + $stat->grade_p5_boys + $stat->grade_p5_girls + $stat->grade_p6_boys + $stat->grade_p6_girls }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-500">มัธยม</p>
                                        <p class="font-bold text-purple-600">{{ $stat->grade_m1_boys + $stat->grade_m1_girls + $stat->grade_m2_boys + $stat->grade_m2_girls + $stat->grade_m3_boys + $stat->grade_m3_girls }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Info -->
                            <div class="mt-4 pt-4 border-t border-gray-200 text-xs text-gray-500">
                                <p>📅 อัพเดตเมื่อ: {{ $stat->updated_at->format('d/m/Y H:i') }}</p>
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
        <p>&copy; {{ date('Y') }} {{ $schoolInfo?->school_name ?? 'โรงเรียน' }}. สงวนสิทธิ์ทั้งหมด</p>
    </div>
</footer>
