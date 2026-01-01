<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_stats', function (Blueprint $table) {
            // ชั้นประถม 1-3
            $table->integer('grade_k1_boys')->default(0)->after('academic_year');
            $table->integer('grade_k1_girls')->default(0)->after('grade_k1_boys');
            $table->integer('grade_k2_boys')->default(0)->after('grade_k1_girls');
            $table->integer('grade_k2_girls')->default(0)->after('grade_k2_boys');
            $table->integer('grade_k3_boys')->default(0)->after('grade_k2_girls');
            $table->integer('grade_k3_girls')->default(0)->after('grade_k3_boys');
            
            // ชั้นประถม 4-6
            $table->integer('grade_p1_boys')->default(0)->after('grade_k3_girls');
            $table->integer('grade_p1_girls')->default(0)->after('grade_p1_boys');
            $table->integer('grade_p2_boys')->default(0)->after('grade_p1_girls');
            $table->integer('grade_p2_girls')->default(0)->after('grade_p2_boys');
            $table->integer('grade_p3_boys')->default(0)->after('grade_p2_girls');
            $table->integer('grade_p3_girls')->default(0)->after('grade_p3_boys');
            $table->integer('grade_p4_boys')->default(0)->after('grade_p3_girls');
            $table->integer('grade_p4_girls')->default(0)->after('grade_p4_boys');
            $table->integer('grade_p5_boys')->default(0)->after('grade_p4_girls');
            $table->integer('grade_p5_girls')->default(0)->after('grade_p5_boys');
            $table->integer('grade_p6_boys')->default(0)->after('grade_p5_girls');
            $table->integer('grade_p6_girls')->default(0)->after('grade_p6_boys');
            
            // ชั้นมัธยม 1-3
            $table->integer('grade_m1_boys')->default(0)->after('grade_p6_girls');
            $table->integer('grade_m1_girls')->default(0)->after('grade_m1_boys');
            $table->integer('grade_m2_boys')->default(0)->after('grade_m1_girls');
            $table->integer('grade_m2_girls')->default(0)->after('grade_m2_boys');
            $table->integer('grade_m3_boys')->default(0)->after('grade_m2_girls');
            $table->integer('grade_m3_girls')->default(0)->after('grade_m3_boys');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_stats', function (Blueprint $table) {
            $table->dropColumn([
                'grade_k1_boys', 'grade_k1_girls',
                'grade_k2_boys', 'grade_k2_girls',
                'grade_k3_boys', 'grade_k3_girls',
                'grade_p1_boys', 'grade_p1_girls',
                'grade_p2_boys', 'grade_p2_girls',
                'grade_p3_boys', 'grade_p3_girls',
                'grade_p4_boys', 'grade_p4_girls',
                'grade_p5_boys', 'grade_p5_girls',
                'grade_p6_boys', 'grade_p6_girls',
                'grade_m1_boys', 'grade_m1_girls',
                'grade_m2_boys', 'grade_m2_girls',
                'grade_m3_boys', 'grade_m3_girls',
            ]);
        });
    }};