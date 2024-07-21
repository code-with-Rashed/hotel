<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    public function getLogoAttribute($photo)
    {
        return asset('storage') . "/" . $photo;
    }
}
