<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['gallery_id','filename','file_size','file_path'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getUrlAttribute()
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    public function getThumbUrlAttribute()
    {
        if (! $this->file_path) return null;
        // file_path is like 'storage/gallery/xxxxx.jpg'
        $parts = explode('/', $this->file_path);
        $filename = array_pop($parts);
        $thumb = 'storage/gallery/thumb_' . $filename;

        if (file_exists(public_path($thumb))) {
            return asset($thumb);
        }

        // fallback to main image
        return $this->url;
    }
}
