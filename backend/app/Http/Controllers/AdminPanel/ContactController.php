<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends BaseController
{
    // show contact details
    public function index()
    {
        $results["contacts"] = Contact::orderBy('status', 'desc')->paginate(5);
        return $this->send_response(message: "Contacts Data .", results: $results);
    }

    // create new contact request
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email",
            "subject" => "required|string",
            "message" => "required|string"
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

    // show single contact message
    public function show($id)
    {
        $contact = Contact::find($id);
        if (!$contact->status) {
            $contact->status = 1; // The message mark as read
            $contact->save();
        }
        $results["contact"] = $contact;
        return $this->send_response(message: "View contact message .", results: $results);
    }

    // update contact message status
    public function update($id)
    {
        $contact = Contact::find($id);

        if ($contact->status) {
            $contact->status = 0;
            $message = "The message mark as unread .";
        } else {
            $contact->status = 1;
            $message = "The message mark as read .";
        }

        $contact->save();
        return $this->send_response(message: $message);
    }

    // update all contact message status
    public function update_all()
    {
        Contact::where('status', 0)->update(['status' => 1]);
        return $this->send_response('updated all contact message status successfully .');
    }

    // delete contact message
    public function delete($id)
    {
        $contact = Contact::find($id);
        if (!is_null($contact)) {
            $contact->delete();
            return $this->send_response(message: "The message successfully deleted .");
        }
    }

    // delete all contact messages
    public function delete_all()
    {
        Contact::truncate();
        return $this->send_response(message: "All contact messages are successfully deleted .");
    }
}
