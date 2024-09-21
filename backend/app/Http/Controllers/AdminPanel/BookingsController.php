<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingDetail;
use App\Models\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingsController extends BaseController
{
    public $search = null;
    // response all booking records
    public function all_bookings($search = null)
    {
        $this->search = $search;
        $all_bookings["all_bookings"] = BookingOrder::join("booking_details", "booking_orders.id", "booking_details.booking_order_id")
            ->where(function ($query) {
                $query->where([["booking_status", "=", "refunded"], ["refund", "=", 1]]);
                $query->orWhere("booking_status", "=", "booked");
                $query->orWhere("booking_status", "=", "pending");
            })
            ->where(function ($query) {
                $query->where("tran_id", "like", "%$this->search%");
                $query->orWhere("room_name", "like", "%$this->search%");
                $query->orWhere("user_name", "like", "%$this->search%");
                $query->orWhere("phone", "like", "%$this->search%");
                $query->orWhere("email", "like", "%$this->search%");
            })
            ->orderBy('booking_orders.id', 'desc')
            ->paginate(4);
        return $this->send_response('All booking records.', $all_bookings);
    }

    // response new booking records
    public function new_bookings($search = null)
    {
        $this->search = $search;
        $new_bookings["new_bookings"] = BookingOrder::join("booking_details", "booking_orders.id", "booking_details.booking_order_id")
            ->where([["booking_status", "=", "booked"], ["arrival", "=", 0]])
            ->where(function ($query) {
                $query->where("tran_id", "like", "%$this->search%");
                $query->orWhere("room_name", "like", "%$this->search%");
                $query->orWhere("user_name", "like", "%$this->search%");
                $query->orWhere("phone", "like", "%$this->search%");
                $query->orWhere("email", "like", "%$this->search%");
            })
            ->orderBy('booking_orders.id', 'desc')
            ->paginate(4);
        return $this->send_response('All new booking records.', $new_bookings);
    }

    // response refund booking records
    public function refund_bookings($search = null)
    {
        $this->search = $search;
        $refund_bookings["refund_bookings"] = BookingOrder::join("booking_details", "booking_orders.id", "booking_details.booking_order_id")
            ->where([["booking_status", "=", "cancelled"], ["refund", "=", 0]])
            ->where(function ($query) {
                $query->where("tran_id", "like", "%$this->search%");
                $query->orWhere("room_name", "like", "%$this->search%");
                $query->orWhere("user_name", "like", "%$this->search%");
                $query->orWhere("phone", "like", "%$this->search%");
                $query->orWhere("email", "like", "%$this->search%");
            })
            ->paginate(4);
        return $this->send_response('Refund booking records.', $refund_bookings);
    }

    // room assign for users
    public function room_assign(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "id" => "required|integer",
            "room_no" => "required"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        // user is arrived
        $booking_order = BookingOrder::find($request->id);
        $booking_order->arrival = 1;
        $booking_order->save();

        // user room is assigned
        $booking_details = BookingDetail::where("booking_order_id", $request->id)->first();
        $booking_details->room_no = $request->room_no;
        $booking_details->save();

        return $this->send_response("Room successfully assigned for user.");
    }
}
