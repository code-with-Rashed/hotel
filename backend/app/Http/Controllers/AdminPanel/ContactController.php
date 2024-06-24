<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // show contact details
    public function index()
    {
        $contact = Contact::all();
        return response([
            "success" => true,
            "contact" => $contact
        ], 200);
    }

    // create new contact request
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "subject" => "required|string",
            "message" => "required|string"
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        return response([
            "success" => true,
            "message" => "Contact details successfully send .",
        ], 201);
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

        return response([
            "success" => true,
            "message" => $message,
        ], 200);
    }

    // delete contact message
    public function delete($id)
    {
        $contact = Contact::find($id);
        if (!is_null($contact)) {
            $contact->delete();
            return response([
                "success" => true,
                "message" => "The message successfully deleted .",
            ], 200);
        }
    }
}
