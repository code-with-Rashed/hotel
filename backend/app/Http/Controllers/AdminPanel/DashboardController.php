<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;
use App\Models\Contact;
use App\Models\RatingReview;

class DashboardController extends BaseController
{
    // response achivement summary
    public function summary()
    {
        $results["new_bookings"] = BookingOrder::where([["booking_status", "booked"], ["arrival", 0]])->count();
        $results["request_refund_bookings"] = BookingOrder::where([["booking_status", "cancelled"], ["refund", 0]])->count();
        $results["new_contacts"] = Contact::where("status", 0)->count();
        $results["new_ratings_reviews"] = RatingReview::where("seen", 0)->count();
        return $this->send_response("achivement summary", $results);
    }
}
