<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\StudentStat;
use App\Models\SchoolInfo;
use App\Models\Building;
use App\Models\Suggestion;
use App\Models\Subject;
use App\Models\Financial;
use App\Models\Download;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin account (for immediate login)
        // Important: this is the first admin account
        User::firstOrCreate([
            'email' => 'admin@watpradu.ac.th'
        ], [
            'name' => 'Admin Watpradu',
            'password' => Hash::make('password'), // password is "password"
            'email_verified_at' => now(),
        ]);

        // Create some dummy users
        User::factory()->count(5)->create();

        // 2. Sample posts
        Post::create([
            'title' => 'ข่าวประชาสัมพันธ์: เปิดเรียนภาคเรียนใหม่',
            'content' => 'ยินดีต้อนรับสู่ภาคเรียนใหม่ ปีการศึกษา 2025',
            'image' => null,
            'tags' => 'announcement,term-start',
            'type' => 'news',
            'pinned' => true,
            'active' => true,
        ]);

        Post::create([
            'title' => 'กิจกรรม: วันวิชาการ',
            'content' => 'โรงเรียนจะจัดงานวันวิชาการในวันที่ ...',
            'type' => 'activity',
            'pinned' => false,
            'active' => true,
        ]);

        // 3. Sample teachers
        Teacher::create(['name' => 'นางสาวสมศรี ใจดี', 'tel' => '02-123-4567', 'email' => 'somsri@example.com', 'position' => 'ครูประจำชั้น', 'image' => null]);
        Teacher::create(['name' => 'นายสมชาย เก่งมาก', 'tel' => '02-765-4321', 'email' => 'somchai@example.com', 'position' => 'ครูคณิตศาสตร์', 'image' => null]);

        // 4. Student statistics (per academic year)
        $stat = StudentStat::create([
            'academic_year' => '2024/2025',
            'count_male' => 120,
            'count_female' => 130,
            'k1' => 10, 'k2' => 12, 'k3' => 11,
            'p1' => 20, 'p2' => 19, 'p3' => 18,
            'p4' => 22, 'p5' => 23, 'p6' => 24,
            'm1' => 12, 'm2' => 13, 'm3' => 11,
            'total_students' => (120 + 130),
        ]);

        // 5. School info (single row)
        SchoolInfo::firstOrCreate([], [
            'schoolname' => 'Watpradu School',
            'history' => 'โรงเรียนก่อตั้งเมื่อปีพ.ศ. ...',
            'motto' => 'ปัญญา นำชัย',
            'vision' => 'มุ่งสู่ความเป็นเลิศทางการศึกษา',
            'mission' => 'พัฒนาเด็กนักเรียนให้มีคุณภาพ',
            'tel' => '02-000-0000',
            'address' => '123 ถนนตัวอย่าง เขตตัวอย่าง จังหวัด',
            'email' => 'info@watpradu.ac.th',
            'logo' => null,
            'screen' => null,
            'map_image' => null,
        ]);

        // 6. Buildings
        Building::create(['name' => 'อาคารเรียน 1', 'image' => null]);
        Building::create(['name' => 'อาคารอำนวยการ', 'image' => null]);

        // 7. Suggestions
        Suggestion::create(['submitter_name' => 'ผู้ปกครอง', 'message' => 'อยากให้เพิ่มกิจกรรมเสริมทักษะ', 'status' => 'pending']);

        // 8. Subjects
        Subject::create(['code' => 'MATH101', 'name' => 'คณิตศาสตร์พื้นฐาน', 'teacher_name' => 'นายสมชาย เก่งมาก']);
        Subject::create(['code' => 'THAI101', 'name' => 'ภาษาไทย', 'teacher_name' => 'นางสาวสมศรี ใจดี']);

        // 9. Financials
        Financial::create(['topic' => 'งบประมาณรายเดือน', 'description' => 'ประกาศงบประมาณประจำเดือน', 'image' => null]);

        // 10. Downloads
        Download::create(['topic' => 'แบบฟอร์มบันทึกคะแนน', 'filename' => 'score_sheet.pdf', 'file_path' => 'docs/score_sheet.pdf']);

        // 11. Galleries and images
        $g = Gallery::create(['activity_name' => 'กิจกรรมทัศนศึกษา']);
        // gallery_images table requires a gallery_id and filename — attach to created gallery
        $gi = new GalleryImage();
        $gi->gallery_id = $g->id;
        $gi->filename = 'placeholder.jpg';
        $gi->file_size = 0;
        $gi->created_at = now();
        $gi->updated_at = now();
        $gi->save();

        // Events (sample)
        Event::create(['title' => 'ทำบุญตักบาตร', 'start_time' => now()->addDays(7), 'end_time' => now()->addDays(7)->addHours(2)]);
    }
}
