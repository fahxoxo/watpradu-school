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
        Schema::table('gallery_images', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_images', 'gallery_id')) {
                $table->unsignedBigInteger('gallery_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('gallery_images', 'filename')) {
                $table->string('filename')->nullable()->after('gallery_id');
            }
            if (!Schema::hasColumn('gallery_images', 'file_size')) {
                $table->unsignedBigInteger('file_size')->default(0)->after('filename');
            }
            if (!Schema::hasColumn('gallery_images', 'file_path')) {
                $table->string('file_path')->nullable()->after('file_size');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_images', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('gallery_images', 'file_size')) {
                $table->dropColumn('file_size');
            }
            if (Schema::hasColumn('gallery_images', 'filename')) {
                $table->dropColumn('filename');
            }
            if (Schema::hasColumn('gallery_images', 'gallery_id')) {
                $table->dropColumn('gallery_id');
            }
        });
    }
};
