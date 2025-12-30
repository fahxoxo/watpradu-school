<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'tel', 'email', 'position', 'image'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : null;
    }
}
