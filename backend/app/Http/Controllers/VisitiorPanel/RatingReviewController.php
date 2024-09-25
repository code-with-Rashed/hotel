<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\RatingReview;

class RatingReviewController extends BaseController
{
    // response rating & review for room
    public function index($room_id)
    {
        $rating_review["rating_review"] = RatingReview::with("user:id,name,photo")->where([["room_id", $room_id], ["seen", 1]])->orderBy("id", "desc")->get();
        return $this->send_response("Rating & Review", $rating_review);
    }
}
