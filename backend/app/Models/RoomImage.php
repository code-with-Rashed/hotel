<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    public function getImageAttribute($photo)
    {
        return asset('storage') . "/" . $photo;
    }
}
