<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentStat extends Model
{
    protected $fillable = [
        'academic_year',
        // ประถม 1-3
        'grade_k1_boys', 'grade_k1_girls',
        'grade_k2_boys', 'grade_k2_girls',
        'grade_k3_boys', 'grade_k3_girls',
        // ประถม 4-6
        'grade_p1_boys', 'grade_p1_girls',
        'grade_p2_boys', 'grade_p2_girls',
        'grade_p3_boys', 'grade_p3_girls',
        'grade_p4_boys', 'grade_p4_girls',
        'grade_p5_boys', 'grade_p5_girls',
        'grade_p6_boys', 'grade_p6_girls',
        // มัธยม 1-3
        'grade_m1_boys', 'grade_m1_girls',
        'grade_m2_boys', 'grade_m2_girls',
        'grade_m3_boys', 'grade_m3_girls',
    ];

    /**
     * รวมจำนวนนักเรียนชายทั้งหมด
     */
    public function getCountMaleAttribute()
    {
        return $this->grade_k1_boys + $this->grade_k2_boys + $this->grade_k3_boys +
               $this->grade_p1_boys + $this->grade_p2_boys + $this->grade_p3_boys +
               $this->grade_p4_boys + $this->grade_p5_boys + $this->grade_p6_boys +
               $this->grade_m1_boys + $this->grade_m2_boys + $this->grade_m3_boys;
    }

    /**
     * รวมจำนวนนักเรียนหญิงทั้งหมด
     */
    public function getCountFemaleAttribute()
    {
        return $this->grade_k1_girls + $this->grade_k2_girls + $this->grade_k3_girls +
               $this->grade_p1_girls + $this->grade_p2_girls + $this->grade_p3_girls +
               $this->grade_p4_girls + $this->grade_p5_girls + $this->grade_p6_girls +
               $this->grade_m1_girls + $this->grade_m2_girls + $this->grade_m3_girls;
    }

    /**
     * รวมจำนวนนักเรียนทั้งหมด
     */
    public function getTotalStudentsAttribute()
    {
        return $this->count_male + $this->count_female;
    }
}

