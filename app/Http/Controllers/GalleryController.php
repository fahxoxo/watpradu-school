<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Models\Gallery;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('images')->orderBy('created_at', 'desc')->get();
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'images.*' => 'image|max:5120',
        ]);

        $gallery = Gallery::create(['activity_name' => $request->activity_name]);

        if ($request->hasFile('images')) {
            // Ensure directory exists
            Storage::makeDirectory('public/gallery');

            foreach ($request->file('images') as $file) {
                // generate a safe unique filename (store as jpg to normalize)
                $base = Str::random(16) . '-' . time();
                $storedFilename = $base . '.jpg';
                $thumbFilename = 'thumb_' . $storedFilename;

                // Resize main image (max width 1200) and save as jpg with quality 85
                // If GD is available, resize; otherwise store original file and warn in logs
                $sourcePath = $file->getRealPath();
                $destPath = storage_path('app/public/gallery/' . $storedFilename);
                $thumbPath = storage_path('app/public/gallery/' . $thumbFilename);

                if (extension_loaded('gd')) {
                    // Ensure destination dir exists
                    if (!is_dir(dirname($destPath))) mkdir(dirname($destPath), 0777, true);

                    // Resize main image (max width 1200)
                    $this->resizeImageToJpeg($sourcePath, $destPath, 1200, 85);

                    // Create thumbnail (max width 400)
                    $this->resizeImageToJpeg($sourcePath, $thumbPath, 400, 80);

                    // Make sure storage sees the files
                    clearstatcache(true, $destPath);
                    clearstatcache(true, $thumbPath);
                } else {
                    // fallback: store original file as-is
                    $path = $file->storeAs('public/gallery', $storedFilename);
                    // create a simple thumb by copying the same file (not resized)
                    Storage::copy($path, 'public/gallery/' . $thumbFilename);
                    logger()->warning('GD extension not available; images stored without resizing. Install php-gd or imagick for auto-resize.');
                }

                // Save DB record (file_path points to public URL)
                $path = 'storage/gallery/' . $storedFilename;
                // determine file size safely (Flysystem may fail to retrieve metadata for directly-written files)
                try {
                    $size = Storage::size('public/gallery/' . $storedFilename);
                } catch (\Exception $e) {
                    // fallback to local filesize or uploaded file size
                    if (file_exists($destPath)) {
                        $size = filesize($destPath);
                    } else {
                        $size = $file->getSize();
                    }
                }

                $gallery->images()->create([
                    'filename' => $file->getClientOriginalName(),
                    'file_size' => $size,
                    'file_path' => $path,
                ]);
            }
        }
        return redirect()->route('galleries.index')->with('success', 'สร้างอัลบั้มเรียบร้อย');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return view('galleries.show', compact('gallery'));
    }

    public function destroy(Gallery $gallery)
    {
        // Optionally delete files from storage; currently only delete DB records
        foreach ($gallery->images as $img) {
            // Storage::delete(str_replace('storage/', 'public/', $img->file_path));
            $img->delete();
        }
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'ลบอัลบั้มเรียบร้อย');
    }

    /**
     * Resize image to JPEG using GD and save to path
     */
    protected function resizeImageToJpeg(string $sourcePath, string $destPath, int $maxWidth, int $quality = 85)
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

        // create source image
        $mime = $info['mime'] ?? '';
        switch ($mime) {
            case 'image/jpeg': $src = imagecreatefromjpeg($sourcePath); break;
            case 'image/png': $src = imagecreatefrompng($sourcePath); break;
            case 'image/gif': $src = imagecreatefromgif($sourcePath); break;
            default: $src = imagecreatefromstring(file_get_contents($sourcePath)); break;
        }

        if (! $src) return false;

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        // preserve transparency for PNG/GIF
        if ($mime === 'image/png' || $mime === 'image/gif') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // save as jpeg
        imagejpeg($dst, $destPath, $quality);

        imagedestroy($src);
        imagedestroy($dst);

        return true;
    }

    public function publicIndex()
    {
        $galleries = Gallery::withCount('images')->orderBy('created_at', 'desc')->get();
        $schoolInfo = \App\Models\SchoolInfo::first();
        return view('public.galleries', compact('galleries', 'schoolInfo'));
    }

    public function publicShow(Gallery $gallery)
    {
        $schoolInfo = \App\Models\SchoolInfo::first();
        return view('public.galleries-detail', compact('gallery', 'schoolInfo'));
    }
}
