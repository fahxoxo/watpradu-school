@include('components.header', ['schoolInfo' => $schoolInfo])

<div class="container mx-auto px-4 py-8 bg-gray-50 min-h-screen">
    <!-- Back Button >
    <div class="mb-6">
        <a href="{{ route('students.public') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            กลับไป
        </a>
    </div-->

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">สถิติ นักเรียน ปีการศึกษา {{ $stat->academic_year }}</h1>
        <p class="text-gray-600">รายละเอียดข้อมูลจำนวนนักเรียนแยกตามชั้นปี เพศชาย-หญิง</p>
    </div>

    <!-- Overall Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm mb-2">นักเรียนชายทั้งหมด</p>
            <p class="text-4xl font-bold text-blue-600">{{ $stat->count_male }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-500">
            <p class="text-gray-600 text-sm mb-2">นักเรียนหญิงทั้งหมด</p>
            <p class="text-4xl font-bold text-pink-600">{{ $stat->count_female }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm mb-2">รวมทั้งสิ้น</p>
            <p class="text-4xl font-bold text-green-600">{{ $stat->total_students }}</p>
        </div>
    </div>

    <!-- Grade Levels Details -->
    <div class="space-y-6">
        <!-- Kindergarten Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-orange-400 to-orange-500 text-white p-6">
                <h2 class="text-2xl font-bold">ชั้นอนุบาลศึกษา 1-3</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $grades_k = [
                            ['key' => 'k1', 'label' => 'อนุบาล 1'],
                            ['key' => 'k2', 'label' => 'อนุบาล 2'],
                            ['key' => 'k3', 'label' => 'อนุบาล 3'],
                        ];
                    @endphp
                    @foreach($grades_k as $grade)
                    @php
                        $boys_key = "grade_" . $grade['key'] . "_boys";
                        $girls_key = "grade_" . $grade['key'] . "_girls";
                        $boys = $stat->$boys_key ?? 0;
                        $girls = $stat->$girls_key ?? 0;
                        $total = $boys + $girls;
                    @endphp
                    <div class="border border-orange-200 rounded-lg p-4">
                        <h3 class="text-lg font-bold text-orange-600 mb-4">{{ $grade['label'] }}</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">ชาย</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $boys }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">หญิง</span>
                                <span class="text-2xl font-bold text-pink-600">{{ $girls }}</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">รวม</span>
                                    <span class="text-2xl font-bold text-orange-600">{{ $total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-700">รวมอนุบาลศึกษา</span>
                        <span class="text-2xl font-bold text-orange-600">
                            {{ ($stat->grade_k1_boys + $stat->grade_k1_girls) + 
                               ($stat->grade_k2_boys + $stat->grade_k2_girls) + 
                               ($stat->grade_k3_boys + $stat->grade_k3_girls) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elementary School Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6">
                <h2 class="text-2xl font-bold">ชั้นประถมศึกษา 1-6</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @php
                        $grades_p = [
                            ['key' => 'p1', 'label' => 'ป.1'],
                            ['key' => 'p2', 'label' => 'ป.2'],
                            ['key' => 'p3', 'label' => 'ป.3'],
                            ['key' => 'p4', 'label' => 'ป.4'],
                            ['key' => 'p5', 'label' => 'ป.5'],
                            ['key' => 'p6', 'label' => 'ป.6'],
                        ];
                    @endphp
                    @foreach($grades_p as $grade)
                    @php
                        $boys_key = "grade_" . $grade['key'] . "_boys";
                        $girls_key = "grade_" . $grade['key'] . "_girls";
                        $boys = $stat->$boys_key ?? 0;
                        $girls = $stat->$girls_key ?? 0;
                        $total = $boys + $girls;
                    @endphp
                    <div class="border border-green-200 rounded-lg p-3">
                        <h3 class="text-center font-bold text-green-600 mb-3">{{ $grade['label'] }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ชาย</span>
                                <span class="font-bold text-blue-600">{{ $boys }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">หญิง</span>
                                <span class="font-bold text-pink-600">{{ $girls }}</span>
                            </div>
                            <div class="pt-2 border-t border-gray-200">
                                <div class="flex justify-between font-bold">
                                    <span class="text-gray-700">รวม</span>
                                    <span class="text-green-600">{{ $total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-700">รวมประถมศึกษา</span>
                        <span class="text-2xl font-bold text-green-600">
                            {{ ($stat->grade_p1_boys + $stat->grade_p1_girls) + 
                               ($stat->grade_p2_boys + $stat->grade_p2_girls) + 
                               ($stat->grade_p3_boys + $stat->grade_p3_girls) +
                               ($stat->grade_p4_boys + $stat->grade_p4_girls) +
                               ($stat->grade_p5_boys + $stat->grade_p5_girls) +
                               ($stat->grade_p6_boys + $stat->grade_p6_girls) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary School Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-purple-400 to-purple-500 text-white p-6">
                <h2 class="text-2xl font-bold">ชั้นมัธยมศึกษา 1-3</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $grades_m = [
                            ['key' => 'm1', 'label' => 'ม.1'],
                            ['key' => 'm2', 'label' => 'ม.2'],
                            ['key' => 'm3', 'label' => 'ม.3'],
                        ];
                    @endphp
                    @foreach($grades_m as $grade)
                    @php
                        $boys_key = "grade_" . $grade['key'] . "_boys";
                        $girls_key = "grade_" . $grade['key'] . "_girls";
                        $boys = $stat->$boys_key ?? 0;
                        $girls = $stat->$girls_key ?? 0;
                        $total = $boys + $girls;
                    @endphp
                    <div class="border border-purple-200 rounded-lg p-4">
                        <h3 class="text-lg font-bold text-purple-600 mb-4">{{ $grade['label'] }}</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">ชาย</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $boys }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">หญิง</span>
                                <span class="text-2xl font-bold text-pink-600">{{ $girls }}</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">รวม</span>
                                    <span class="text-2xl font-bold text-purple-600">{{ $total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-700">รวมมัธยมศึกษา</span>
                        <span class="text-2xl font-bold text-purple-600">
                            {{ ($stat->grade_m1_boys + $stat->grade_m1_girls) + 
                               ($stat->grade_m2_boys + $stat->grade_m2_girls) + 
                               ($stat->grade_m3_boys + $stat->grade_m3_girls) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Info Footer -->
    <div class="mt-8 bg-white rounded-lg shadow p-6 text-center text-gray-600 text-sm">
        <p>📅 อัพเดตเมื่อ: {{ $stat->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
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
