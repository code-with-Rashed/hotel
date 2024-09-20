<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyBookingsController extends BaseController
{
    // show all booking records for users
    public function index($user_id)
    {
        $mybookings = BookingOrder::with('booking_details')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return $this->send_response('Booking Records.', $mybookings);
    }

    // cancel booking order
    public function cancel(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "order_id" => "required|integer",
            "user_id" => "required|integer"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }
        $booking_order = BookingOrder::where([['id', $request->order_id], ['user_id', $request->user_id]])->first();
        $booking_order->booking_status = "cancelled";
        $booking_order->refund = 0;
        $booking_order->save();
        return $this->send_response('Your booking is cancelled. Refund in Proccess.');
    }
}
