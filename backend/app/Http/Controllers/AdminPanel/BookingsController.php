<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;

class BookingsController extends BaseController
{
    public $search = null;
    // response all booking records
    public function all_bookings($search = null)
    {
        $this->search = $search;
        $all_bookings["new_bookings"] = BookingOrder::join("booking_details", "booking_orders.id", "booking_details.booking_order_id")
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
        return $this->send_response('All booking record.', $all_bookings);
    }

    // response new booking records
    public function new_bookings($search = null)
    {
        $this->search = $search;
        $all_bookings["new_bookings"] = BookingOrder::join("booking_details", "booking_orders.id", "booking_details.booking_order_id")
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
        return $this->send_response('All booking record.', $all_bookings);
    }
}
