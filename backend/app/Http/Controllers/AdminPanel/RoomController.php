<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // show all rooms
    public function index()
    {
        $rooms = Room::all();
        return response([
            "success" => true,
            "rooms" => $rooms
        ]);
    }

    // create a new room
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|integer",
            "area" => "required|integer",
            "adult" => "required|integer",
            "children" => "required|integer",
            "description" => "required|string"
        ]);

        $room = new Room();
        $room->name = $request->name;
        $room->price = $request->price;
        $room->quantity = $request->quantity;
        $room->area = $request->area;
        $room->adult = $request->adult;
        $room->children = $request->children;
        $room->description = $request->description;
        $room->save();

        return response([
            "success" => true,
            "message" => "New Room successfully created .",
        ], 201);
    }

    // show single room
    public function show($id)
    {
        $room = Room::find($id);
        return response([
            "success" => true,
            "room" => $room
        ]);
    }

    // update room record
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|integer",
            "area" => "required|integer",
            "adult" => "required|integer",
            "children" => "required|integer",
            "description" => "required|string"
        ]);

        $room = Room::find($id);
        $room->name = $request->name;
        $room->price = $request->price;
        $room->quantity = $request->quantity;
        $room->area = $request->area;
        $room->adult = $request->adult;
        $room->children = $request->children;
        $room->description = $request->description;
        $room->save();

        return response([
            "success" => true,
            "message" => "Room record successfully updated .",
        ]);
    }

    // update room status
    public function status($id)
    {
        $room = Room::find($id);

        if ($room->status) {
            $room->status = 0;
            $message = "The room has been activate .";
        } else {
            $room->status = 1;
            $message = "The room has been inactivate .";
        }
        $room->save();

        return response([
            "success" => true,
            "message" => $message
        ]);
    }
}
