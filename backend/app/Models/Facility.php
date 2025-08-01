<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    public function getImageAttribute($photo)
    {
        return asset('storage') . "/" . $photo;
    }

    // assigned room's facilities
    public function room_facilities()
    {
        return $this->hasMany(RoomFacility::class);
    }
}
