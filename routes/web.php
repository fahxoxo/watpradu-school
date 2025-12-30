<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SchoolInfoController;
use App\Models\Post;
use App\Models\SchoolInfo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $pinnedPosts = Post::where('pinned', true)->where('active', true)->latest()->get();
    $latestNews = Post::where('type', 'news')->where('active', true)->latest()->take(3)->get();
    $latestActivities = Post::where('type', 'activity')->where('active', true)->latest()->take(3)->get();
    $schoolInfo = SchoolInfo::first();
    
    return view('welcome', compact('pinnedPosts', 'latestNews', 'latestActivities', 'schoolInfo'));
});

// Public post detail view - pass schoolInfo for logo
Route::get('/posts/{post}', function (Post $post) {
    $schoolInfo = App\Models\SchoolInfo::first();
    if (!$post->active) abort(404);
    return view('posts.show', compact('post', 'schoolInfo'));
})->name('posts.show');

// Public suggestion form - pass schoolInfo for logo
Route::get('/suggestions/create', function () {
    $schoolInfo = App\Models\SchoolInfo::first();
    return view('suggestions.create', compact('schoolInfo'));
})->name('suggestions.create');
Route::post('/suggestions', [App\Http\Controllers\SuggestionController::class, 'store'])->name('suggestions.store');

// Public financial page
Route::get('/financial', function () {
    $items = App\Models\Financial::orderBy('id', 'desc')->get();
    $schoolInfo = App\Models\SchoolInfo::first();
    return view('public.financial', compact('items', 'schoolInfo'));
})->name('financial.public');

// Public financial detail page - pass schoolInfo for logo
Route::get('/financial/{financial}', function (App\Models\Financial $financial) {
    $schoolInfo = App\Models\SchoolInfo::first();
    return view('financials.public-show', compact('financial', 'schoolInfo'));
})->name('financial.show');

// Public events JSON for homepage calendar
Route::get('/events/public-json', [App\Http\Controllers\EventController::class, 'json'])->name('events.public.json');

// Public about page
Route::get('/about', function () {
    $schoolInfo = App\Models\SchoolInfo::first();
    return view('public.about', compact('schoolInfo'));
})->name('about');

// Public motto/vision page
Route::get('/motto', function () {
    $schoolInfo = App\Models\SchoolInfo::first();
    return view('public.motto', compact('schoolInfo'));
})->name('motto');

// Public downloads page
Route::get('/downloads', [App\Http\Controllers\DownloadController::class, 'publicIndex'])->name('downloads.public');
Route::get('/downloads/{type}', [App\Http\Controllers\DownloadController::class, 'publicIndex'])->name('downloads.type')
    ->where('type', 'calendar|leave|schedule|other');
Route::get('/downloads/{download}/download', [App\Http\Controllers\DownloadController::class, 'download'])->name('downloads.download');

// Public teachers list and detail pages
Route::get('/teachers', [App\Http\Controllers\TeacherController::class, 'publicIndex'])->name('teachers.public');
Route::get('/teacher/{teacher}', [App\Http\Controllers\TeacherController::class, 'publicShow'])->name('teacher.show');

// Public student stats page
Route::get('/students', [App\Http\Controllers\StudentStatController::class, 'publicIndex'])->name('students.public');
Route::get('/students/{studentStat}', [App\Http\Controllers\StudentStatController::class, 'publicDetail'])->name('students.detail');

// Public buildings page
Route::get('/buildings', [App\Http\Controllers\BuildingController::class, 'publicIndex'])->name('buildings.public');
Route::get('/buildings/{building}', [App\Http\Controllers\BuildingController::class, 'publicShow'])->name('buildings.show');

// Public news page
Route::get('/news', [App\Http\Controllers\PostController::class, 'publicNews'])->name('posts.news');

// Public activities page
Route::get('/activities', [App\Http\Controllers\PostController::class, 'publicActivities'])->name('posts.activities');

// Public galleries page
Route::get('/galleries-public', [App\Http\Controllers\GalleryController::class, 'publicIndex'])->name('galleries.public');
Route::get('/galleries-public/{gallery}', [App\Http\Controllers\GalleryController::class, 'publicShow'])->name('galleries.public.show');

// Public search page
Route::get('/search', [App\Http\Controllers\PostController::class, 'publicSearch'])->name('posts.search');

Auth::routes(['register' => false]); // ปิดการสมัครสมาชิกทั่วไป ให้แอดมินสร้างเอง

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 1. ข้อมูลโรงเรียน
    Route::get('/school-info', [SchoolInfoController::class, 'edit'])->name('school-info.edit');
    Route::put('/school-info', [SchoolInfoController::class, 'update'])->name('school-info.update');
    
    // Resource Routes สำหรับ CRUD ทั่วไป
    Route::resource('teachers', App\Http\Controllers\TeacherController::class);
    Route::post('teachers/map', [App\Http\Controllers\TeacherController::class, 'mapUpdate'])->name('teachers.map.update');
    Route::delete('teachers/map', [App\Http\Controllers\TeacherController::class, 'mapDestroy'])->name('teachers.map.destroy');
    Route::post('posts/{post}/toggle', [App\Http\Controllers\PostController::class, 'toggle'])->name('posts.toggle');
    Route::resource('posts', App\Http\Controllers\PostController::class)->except(['show']);
    Route::resource('events', App\Http\Controllers\EventController::class);
    Route::get('events/json', [App\Http\Controllers\EventController::class, 'json'])->name('events.json');
    Route::resource('galleries', App\Http\Controllers\GalleryController::class);
    Route::resource('student-stats', App\Http\Controllers\StudentStatController::class);
    Route::resource('subjects', App\Http\Controllers\SubjectController::class);
    // Allow admin to view list, edit status, and update status
    Route::resource('suggestions', App\Http\Controllers\SuggestionController::class)->only(['index', 'edit', 'update']);
    Route::get('suggestions/export', [App\Http\Controllers\SuggestionController::class, 'exportPdf'])->name('suggestions.export');

    // Backup (เริ่มสำรองข้อมูลผ่านหน้าเว็บ) - ใช้ POST เพื่อป้องกัน CSRF
    Route::post('/backup', [DashboardController::class, 'backup'])->name('backup.run');
    
    // Buildings Admin - Manual routes to avoid parameter naming issues
    Route::get('/buildings-manage', [App\Http\Controllers\BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/buildings-manage/create', [App\Http\Controllers\BuildingController::class, 'create'])->name('buildings.create');
    Route::post('/buildings-manage', [App\Http\Controllers\BuildingController::class, 'store'])->name('buildings.store');
    Route::get('/buildings-manage/{building}/edit', [App\Http\Controllers\BuildingController::class, 'edit'])->name('buildings.edit');
    Route::put('/buildings-manage/{building}', [App\Http\Controllers\BuildingController::class, 'update'])->name('buildings.update');
    Route::delete('/buildings-manage/{building}', [App\Http\Controllers\BuildingController::class, 'destroy'])->name('buildings.destroy');

    // Downloads (เอกสารดาวน์โหลด) - Admin only - create, edit, update, destroy
    Route::get('/downloads-manage', [App\Http\Controllers\DownloadController::class, 'index'])->name('downloads.index');
    Route::get('/downloads-manage/create', [App\Http\Controllers\DownloadController::class, 'create'])->name('downloads.create');
    Route::post('/downloads-manage', [App\Http\Controllers\DownloadController::class, 'store'])->name('downloads.store');
    Route::get('/downloads-manage/{download}/edit', [App\Http\Controllers\DownloadController::class, 'edit'])->name('downloads.edit');
    Route::put('/downloads-manage/{download}', [App\Http\Controllers\DownloadController::class, 'update'])->name('downloads.update');
    Route::delete('/downloads-manage/{download}', [App\Http\Controllers\DownloadController::class, 'destroy'])->name('downloads.destroy');

    // Financials (การเงิน)
    Route::resource('financials', App\Http\Controllers\FinancialController::class);
});