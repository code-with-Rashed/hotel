<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;
use App\Models\Contact;
use App\Models\RatingReview;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    // return condition for analytics
    private function what_condition($period)
    {
        switch ($period) {
            case 1:
                $condition = "NOW() - INTERVAL 30 DAY AND NOW()";
                break;

            case 2:
                $condition = "NOW() - INTERVAL 90 DAY AND NOW()";
                break;

            case 3:
                $condition = "NOW() - INTERVAL 1 YEAR AND NOW()";
                break;

            default:
                $condition = "";
                break;
        }
        return $condition;
    }

    // response booking analytics
    public function booking_analytics($period)
    {
        switch ($period) {
            case 1:
                $condition = "NOW() - INTERVAL 30 DAY AND NOW()";
                break;

            case 2:
                $condition = "NOW() - INTERVAL 90 DAY AND NOW()";
                break;

            case 3:
                $condition = "NOW() - INTERVAL 1 YEAR AND NOW()";
                break;

            default:
                $condition = "";
                break;
        }
        $results = BookingOrder::select(
            DB::raw(
                "COUNT(id) AS total_bookings ,
             SUM(amount) AS total_bookings_amount ,
             COUNT(CASE WHEN `booking_status` = 'booked' AND `arrival` = 1 THEN 1 END) AS active_bookings ,
             SUM(CASE WHEN `booking_status` = 'booked' AND `arrival` = 1 THEN amount END) AS active_bookings_amount ,
             COUNT(CASE WHEN `booking_status` = 'cancelled' AND `arrival` = 0 THEN 1 END) AS cancelled_bookings ,
             SUM(CASE WHEN `booking_status` = 'cancelled' AND `arrival` = 0 THEN amount END) AS cancelled_bookings_amount ,
             COUNT(CASE WHEN `booking_status` = 'refunded' AND `refund` = 1 THEN 1 END) AS refunded_bookings ,
             SUM(CASE WHEN `booking_status` = 'refunded' AND `refund` = 1 THEN amount END) AS refunded_bookings_amount"
            )
        )
            ->where("created_at", "<>", $condition)
            ->get();
        return $this->send_response("Booking analytics.", $results);
    }

    // response users, queries, ratings & reviews related analytics .
    public function analytics($period)
    {
        $condition = $this->what_condition($period);
        $results["total_users"] = User::where("created_at", "<>", $condition)->count();
        $results["total_contact_query"] = Contact::where("created_at", "<>", $condition)->count();
        $results["total_ratings_reviews"] = RatingReview::where("created_at", "<>", $condition)->count();
        return $this->send_response("response users, queries, ratings & reviews related analytics .", $results);
    }
}
