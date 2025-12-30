<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register helper function for formatting bytes
        if (!function_exists('formatBytes')) {
            function formatBytes($bytes, $precision = 2) {
                $units = ['B', 'KB', 'MB', 'GB'];
                $bytes = max($bytes, 0);
                $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                $pow = min($pow, count($units) - 1);
                $bytes /= (1 << (10 * $pow));
                return round($bytes, $precision) . ' ' . $units[$pow];
            }
        }
    }
}
