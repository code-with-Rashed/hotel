<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends BaseController
{
    // create new contact request
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string|max:40",
            "email" => "required|email|max:60",
            "subject" => "required|string|max:150",
            "message" => "required|string|max:255"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return $this->send_response(message: "Contact details successfully send .", status_code: 201);
    }
}
