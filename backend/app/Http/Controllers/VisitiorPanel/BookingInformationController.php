<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Room;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BookingInformationController extends BaseController
{
    public $errors = [];

    // check booking information is valid
    public function check_booking_information(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "checkin" => "required|date",
            "checkout" => "required|date",
            "room_id" => "required|integer",
            "room_name" => "required|string",
            "price" => "required|integer",
            "total_day" => "required|integer",
            "total_pay" => "required|integer"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        // date validation
        $today = new DateTime(date('Y-m-d'));
        $checkin = new DateTime($request->checkin);
        $checkout = new DateTime($request->checkout);

        if ($checkin == $checkout) {
            $this->errors[] = "You cannot Check-out of same day !";
        } else if ($checkin < $today) {
            $this->errors[] = "Check-in date is earlier than Today's date !";
        } else if ($checkout < $checkin) {
            $this->errors[] = "Check-out date is earlier than Check-in date !";
        }

        // date between validation
        $total_day = date_diff($checkin, $checkout)->days;
        if ($total_day != $request->total_day) {
            $this->errors[] = "Total day is not match !";
        }

        // get room record
        $room = Room::withCount(['booking_orders' => function ($subquery) use ($checkin, $checkout) {
            $subquery->where([['booking_status', 'booked'], ['checkin', '<', $checkout], ['checkout', '>', $checkin]]);
        }])->find($request->room_id);

        if (!is_null($room)) {
            // check room availability
            if (($room->quantity - $room->booking_orders_count) == 0) {
                $this->errors[] = "Sory this room is not available among $request->checkin - $request->checkout date !";
            }

            // room info validation
            if ($room->name != $request->room_name) {
                $this->errors[] = "Room name is not match !";
            }
            if ($room->price != $request->price) {
                $this->errors[] = "Room price is not match !";
            }

            // total price validation
            if (($room->price * $total_day) != $request->total_pay) {
                $this->errors[] = "Total price is not match !";
            }
        } else {
            $this->errors[] = "Room is Not Found !";
        }

        // response
        if (empty($this->errors)) {
            return $this->send_response('all ok');
        } else {
            return $this->send_error('invalid information', $this->errors);
        }
    }
}
