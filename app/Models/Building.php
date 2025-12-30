<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];

    /**
     * Get full URL for image (if any)
     */
    public function getImageUrlAttribute()
    {
        if (! $this->image) return null;
        return asset('storage/' . $this->image);
    }
}
