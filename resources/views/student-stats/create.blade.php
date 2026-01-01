@extends('layouts.admin')

@section('content')
<h3>เพิ่มข้อมูลสถิติ นักเรียน</h3>

<form action="/student-stats" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">ปีการศึกษา</label>
        <input type="text" name="academic_year" class="form-control" value="{{ old('academic_year') }}" required>
        @error('academic_year')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <!-- ชั้นอนุบาลศึกษา 1-3 -->
    <fieldset class="mb-4 p-3 border rounded">
        <legend class="form-label fw-bold">ชั้นอนุบาลศึกษา 1-3</legend>
        <div class="row">
            @foreach(['grade_k1' => 'อนุบาล 1', 'grade_k2' => 'อนุบาล 2', 'grade_k3' => 'อนุบาล 3'] as $key => $label)
            <div class="col-md-4 mb-3">
                <h6>{{ $label }}</h6>
                <div class="input-group mb-2">
                    <span class="input-group-text">ชาย</span>
                    <input type="number" name="{{ $key }}_boys" class="form-control" value="{{ old($key.'_boys', 0) }}" min="0">
                </div>
                <div class="input-group">
                    <span class="input-group-text">หญิง</span>
                    <input type="number" name="{{ $key }}_girls" class="form-control" value="{{ old($key.'_girls', 0) }}" min="0">
                </div>
            </div>
            @endforeach
        </div>
    </fieldset>

    <!-- ชั้นประถมศึกษา 1-6 -->
    <fieldset class="mb-4 p-3 border rounded">
        <legend class="form-label fw-bold">ชั้นประถมศึกษา 1-6</legend>
        <div class="row">
            @foreach(['grade_p1' => 'ป.1', 'grade_p2' => 'ป.2', 'grade_p3' => 'ป.3', 'grade_p4' => 'ป.4', 'grade_p5' => 'ป.5', 'grade_p6' => 'ป.6'] as $key => $label)
            <div class="col-md-4 mb-3">
                <h6>{{ $label }}</h6>
                <div class="input-group mb-2">
                    <span class="input-group-text">ชาย</span>
                    <input type="number" name="{{ $key }}_boys" class="form-control" value="{{ old($key.'_boys', 0) }}" min="0">
                </div>
                <div class="input-group">
                    <span class="input-group-text">หญิง</span>
                    <input type="number" name="{{ $key }}_girls" class="form-control" value="{{ old($key.'_girls', 0) }}" min="0">
                </div>
            </div>
            @endforeach
        </div>
    </fieldset>

    <!-- ชั้นมัธยม 1-3 -->
    <fieldset class="mb-4 p-3 border rounded">
        <legend class="form-label fw-bold">ชั้นมัธยมศึกษา 1-3</legend>
        <div class="row">
            @foreach(['grade_m1' => 'ม.1', 'grade_m2' => 'ม.2', 'grade_m3' => 'ม.3'] as $key => $label)
            <div class="col-md-4 mb-3">
                <h6>{{ $label }}</h6>
                <div class="input-group mb-2">
                    <span class="input-group-text">ชาย</span>
                    <input type="number" name="{{ $key }}_boys" class="form-control" value="{{ old($key.'_boys', 0) }}" min="0">
                </div>
                <div class="input-group">
                    <span class="input-group-text">หญิง</span>
                    <input type="number" name="{{ $key }}_girls" class="form-control" value="{{ old($key.'_girls', 0) }}" min="0">
                </div>
            </div>
            @endforeach
        </div>
    </fieldset>

    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="{{ route('student-stats.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
</form>
@endsection
