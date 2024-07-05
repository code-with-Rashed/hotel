<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory, HasApiTokens;

    protected $hidden = ['password'];

    public function getPhotoAttribute($photo)
    {
        return asset('storage') . "/" . $photo;
    }
}
