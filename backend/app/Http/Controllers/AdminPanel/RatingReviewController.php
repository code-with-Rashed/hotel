<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\RatingReview;

class RatingReviewController extends BaseController
{
    // response all ratings & reviews
    public function index()
    {
        $ratings_reviews["ratings_reviews"] = RatingReview::with(["user:id,name", "room:id,name"])->orderBy('id', 'desc')->paginate(5);
        return $this->send_response("Ratings & Reviews Record.", $ratings_reviews);
    }

    // update rating & review status
    public function status($id)
    {
        $rating_review = RatingReview::find($id);

        if ($rating_review->seen) {
            $rating_review->seen = 0;
            $message = "The room has been inactivate.";
        } else {
            $rating_review->seen = 1;
            $message = "The room has been activate.";
        }
        $rating_review->save();
        return $this->send_response(message: $message);
    }

    // delete rating & review record
    public function delete($id)
    {
        $rating_review = RatingReview::find($id);
        if (!is_null($rating_review)) {
            $rating_review->delete();
            return $this->send_response(message: "The Rating & Review successfully deleted.");
        }
    }
}
