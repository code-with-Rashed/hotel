<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\BookingOrder;
use App\Models\User;

class UserController extends BaseController
{
    // response all users
    public function index()
    {
        $results["users"] = User::orderBy('id', 'desc')->paginate(5);
        return $this->send_response(message: "Users data .", results: $results);
    }

    // response user activity details
    public function details($user_id)
    {
        $results['details'] = BookingOrder::with("booking_details")->where("user_id", $user_id)->get();
        return $this->send_response(message: "user activity details.", results: $results);
    }

    //update user status
    public function status($id)
    {
        $user = User::find($id);

        if ($user->status) {
            $user->status = 0;
            $message = "The user has been inactivate .";
        } else {
            $user->status = 1;
            $message = "The user has been activate .";
        }
        $user->save();
        return $this->send_response(message: $message);
    }
}
