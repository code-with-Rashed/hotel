<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    // assigned room's features
    public function room_features()
    {
        return $this->hasMany(RoomFeature::class);
    }
}
