<?php

namespace App\Http\Controllers;

use App\Mail\OtpEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class OtpEmailController extends BaseController
{
    // send otp for user email verification
    public function send_email_verify_otp(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|email|max:70",
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            return $this->send_error(message: "This ( $request->email ) email is not exist.");
        }
        // genarate otp
        $otp = rand(11111, 99999);

        // save otp
        $user->remember_token = $otp;
        $user->save();

        // prepare for send otp
        $to_email = $user->email;
        $subject = "Email Verification";
        $message = "Your email verification otp is $otp";
        Mail::to($to_email)->send(new OtpEmail($subject, $message));
        return $this->send_response("You Have an email. so check your email account.");
    }
}
