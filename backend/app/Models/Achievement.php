<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public function getPhotoAttribute($photo)
    {
        return asset('storage') . "/" . $photo;
    }
}
