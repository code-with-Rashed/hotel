<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingDetail;
use App\Models\BookingOrder;
use App\Models\RatingReview;
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

    // save rating & review for room
    public function rating_review(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "booking_order_id" => "required|integer",
            "room_id" => "required|integer",
            "user_id" => "required|integer",
            "star" => "required|integer",
            "message" => "required"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $rating_review = new RatingReview();
        $rating_review->booking_order_id = $request->booking_order_id;
        $rating_review->room_id = $request->room_id;
        $rating_review->user_id = $request->user_id;
        $rating_review->star = $request->star;
        $rating_review->message = $request->message;
        $rating_review->save();

        $booking_details = BookingDetail::where("booking_order_id", $request->booking_order_id)->first();
        $booking_details->rating = 1;
        $booking_details->save();

        return $this->send_response('Thanks For Your Feedback.');
    }
}
