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
        // 1. ข้อมูลพื้นฐานโรงเรียน (แถวเดียว)
    Schema::create('school_infos', function (Blueprint $table) {
        $table->id();
        $table->string('schoolname')->nullable();
        $table->text('history')->nullable();
        $table->text('motto')->nullable();
        $table->text('vision')->nullable();
        $table->text('mission')->nullable();
        $table->string('tel')->nullable();
        $table->text('address')->nullable();
        $table->string('email')->nullable();
        $table->string('logo')->nullable(); // path รูป
        $table->string('screen')->nullable(); // path รูป
        $table->string('map_image')->nullable(); // รูปผังโครงสร้างบุคลากร
        $table->timestamps();
    });

    // 2. ข้อมูลบุคลากร
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('tel')->nullable();
        $table->string('email')->nullable();
        $table->string('position')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();
    });

    // 3. ข่าวและกิจกรรม (ใช้ Type แยก)
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->longText('content');
        $table->string('image')->nullable();
        $table->string('tags')->nullable();
        $table->enum('type', ['news', 'activity']);
        $table->boolean('pinned')->default(false);
        $table->boolean('active')->default(true);
        $table->timestamps();
    });

    // 4. ปฏิทิน
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title', 1000);
        $table->dateTime('start_time');
        $table->dateTime('end_time')->nullable();
        $table->timestamps();
    });

    // 5. อัลบั้มภาพ
    Schema::create('galleries', function (Blueprint $table) {
        $table->id();
        $table->string('activity_name');
        $table->timestamps();
    });



    // 6. ข้อมูลนักเรียน (สถิติรายปี)
    Schema::create('student_stats', function (Blueprint $table) {
        $table->id();
        $table->string('academic_year'); // ปีการศึกษา
        $table->integer('count_male')->default(0);
        $table->integer('count_female')->default(0);
        // แยกรายชั้นเรียน
        $table->integer('k1')->default(0); $table->integer('k2')->default(0); $table->integer('k3')->default(0);
        $table->integer('p1')->default(0); $table->integer('p2')->default(0); $table->integer('p3')->default(0);
        $table->integer('p4')->default(0); $table->integer('p5')->default(0); $table->integer('p6')->default(0);
        $table->integer('m1')->default(0); $table->integer('m2')->default(0); $table->integer('m3')->default(0);
        $table->integer('total_students')->default(0);
        $table->timestamps();
    });

    // 7. วิชาการ
    Schema::create('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('code');
        $table->string('name');
        $table->string('teacher_name');
        $table->timestamps();
    });

    // 8. อาคาร
    Schema::create('buildings', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('image')->nullable();
        $table->timestamps();
    });

    // 9. การเงิน
    Schema::create('financials', function (Blueprint $table) {
        $table->id();
        $table->string('topic');
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();
    });

    // 10. ดาวน์โหลด
    Schema::create('downloads', function (Blueprint $table) {
        $table->id();
        $table->string('topic');
        $table->string('filename'); // ชื่อไฟล์ที่แสดง
        $table->string('file_path'); // Path จริง
        $table->timestamps();
    });

    // 11. ข้อเสนอแนะ
    Schema::create('suggestions', function (Blueprint $table) {
        $table->id();
        $table->string('submitter_name');
        $table->text('message');
        $table->enum('status', ['pending', 'processing', 'completed'])->default('pending');
        $table->timestamps();
    });
    
    // Log จะใช้ Table ของ Spatie/activity-log ที่ติดตั้งมา
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_school_tables');
    }
};
