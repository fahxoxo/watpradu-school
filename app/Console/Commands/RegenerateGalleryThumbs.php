<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GalleryImage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class RegenerateGalleryThumbs extends Command
{
    protected $signature = 'gallery:regenthumbs';

    protected $description = 'Regenerate thumbnails for gallery images (create thumb_ files)';

    public function handle()
    {
        $this->info('Scanning gallery images...');

        if (! extension_loaded('gd')) {
            $this->error('GD extension is not available. Install php-gd (or enable it) to generate thumbnails.');
            return 1;
        }

        $count = 0;

        GalleryImage::chunk(100, function ($rows) use (&$count) {
            foreach ($rows as $img) {
                if (! $img->file_path) continue;

                $parts = explode('/', $img->file_path);
                $filename = array_pop($parts);
                $storagePath = storage_path('app/public/gallery/' . $filename);
                $thumbName = 'thumb_' . $filename;
                $thumbPath = storage_path('app/public/gallery/' . $thumbName);

                if (! file_exists($storagePath)) {
                    $this->warn("File missing: {$storagePath}");
                    continue;
                }

                if (file_exists($thumbPath)) {
                    $this->line("Thumb exists for: {$filename}");
                    continue;
                }

                // Create thumb using GD helper (avoid Image driver issues)
                $this->createThumbFromFile($storagePath, storage_path('app/public/gallery/' . $thumbName));
                Storage::put('public/gallery/' . $thumbName, file_get_contents(storage_path('app/public/gallery/' . $thumbName)));
                $count++;
                $this->line("Created thumb for: {$filename}");
            }
        });

        $this->info("Done. Created {$count} thumbnails.");
    }

    protected function createThumbFromFile(string $sourcePath, string $destPath, int $maxWidth = 400, int $quality = 80)
    {
        $info = getimagesize($sourcePath);
        if (! $info) return false;

        list($width, $height) = $info;
        $ratio = $width / $height;

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = intval($maxWidth / $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        $mime = $info['mime'] ?? '';
        switch ($mime) {
            case 'image/jpeg': $src = imagecreatefromjpeg($sourcePath); break;
            case 'image/png': $src = imagecreatefrompng($sourcePath); break;
            case 'image/gif': $src = imagecreatefromgif($sourcePath); break;
            default: $src = imagecreatefromstring(file_get_contents($sourcePath)); break;
        }

        if (! $src) return false;

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        if ($mime === 'image/png' || $mime === 'image/gif') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($dst, $destPath, $quality);
        imagedestroy($src);
        imagedestroy($dst);
        return true;
    }
}
