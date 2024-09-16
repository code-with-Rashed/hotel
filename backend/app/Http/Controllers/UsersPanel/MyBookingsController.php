<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;

class MyBookingsController extends BaseController
{
    // show all booking records for users
    public function index($user_id)
    {
        $mybookings = BookingOrder::with('booking_details')->where('user_id', $user_id)->get();
        return $this->send_response('Booking Records.', $mybookings);
    }
}
