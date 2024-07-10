<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends BaseController
{
    // show company information
    public function index()
    {
        $results["company_information"] = Information::first();
        return $this->send_response(message: "Company information .", results: $results);
    }

    // update company information
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "address" => "required|string",
            "map" => "required|url:https",
            "email.*" => "required|email",
            "phone.*" => "required|numeric",
            "social.*" => "required|url:https"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $information = Information::first();
        if (!is_null($information)) {
            $information->address = $request->address;
            $information->map = $request->map;
            $information->email = $request->email;
            $information->phone = $request->phone;
            $information->social = $request->social;
            $information->save();
            return $this->send_response(message: "Company information successfully updated .");
        }

        // if information table is empty then create first company information
        $information = new Information();
        $information->address = $request->address;
        $information->map = $request->map;
        $information->email = $request->email;
        $information->phone = $request->phone;
        $information->social = $request->social;
        $information->save();
        return $this->send_response(message: "Company information successfully created .", status_code: 201);
    }
}
