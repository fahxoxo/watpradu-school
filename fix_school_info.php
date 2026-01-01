<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SchoolInfo;

$info = SchoolInfo::first();
if ($info && !empty($info->logo)) {
    // Fix logo path
    if (str_contains($info->logo, 'http://') || str_contains($info->logo, 'localhost')) {
        // Remove full URL and keep just the path
        $info->logo = str_replace('http://localhost:8000/', '', $info->logo);
        $info->logo = str_replace('asset(\'', '', $info->logo);
        $info->logo = str_replace('\')', '', $info->logo);
    }
    
    // Fix screen path
    if (!empty($info->screen) && (str_contains($info->screen, 'http://') || str_contains($info->screen, 'localhost'))) {
        $info->screen = str_replace('http://localhost:8000/', '', $info->screen);
        $info->screen = str_replace('asset(\'', '', $info->screen);
        $info->screen = str_replace('\')', '', $info->screen);
    }
    
    $info->save();
    echo "School info updated successfully\n";
    echo "Logo: " . $info->logo . "\n";
    echo "Screen: " . $info->screen . "\n";
} else {
    echo "No school info found or logo is empty\n";
}
