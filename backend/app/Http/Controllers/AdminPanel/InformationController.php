<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    // show company information
    public function index()
    {
        $information = Information::first();
        return response([
            "success" => true,
            "information" => $information
        ]);
    }

    // update company information
    public function update(Request $request)
    {
        $request->validate([
            "address" => "required|string",
            "map" => "required|url:https",
            "email.*" => "required|email",
            "phone.*" => "required|numeric",
            "social.*" => "required|url:https"
        ]);

        $information = Information::first();
        if (!is_null($information)) {
            $information->address = $request->address;
            $information->map = $request->map;
            $information->email = $request->email;
            $information->phone = $request->phone;
            $information->social = $request->social;
            $information->save();

            return response([
                'success' => true,
                'message' => 'Company information successfully updated !',
            ]);
        }

        // if information table is empty then create first company information
        $information = new Information();
        $information->address = $request->address;
        $information->map = $request->map;
        $information->email = $request->email;
        $information->phone = $request->phone;
        $information->social = $request->social;
        $information->save();

        return response([
            'success' => true,
            'message' => 'Company information successfully created !',
        ], 201);
    }
}
