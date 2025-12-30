<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['activity_name'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
