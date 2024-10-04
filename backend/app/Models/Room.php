<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // assigned room images
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    // assigned Booking orders
    public function booking_orders()
    {
        return $this->hasMany(BookingOrder::class);
    }

    // assigned room features
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'room_features');
    }

    // assigned room facilities
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities');
    }

    // assigned room ratings & reviews
    public function rating_review()
    {
        return $this->hasMany(RatingReview::class);
    }
}
