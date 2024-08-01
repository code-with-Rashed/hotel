<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends BaseController
{
    // show all rooms
    public function index()
    {
        $results["rooms"] = Room::all();
        return $this->send_response(message: "Rooms data .", results: $results);
    }

    // create a new room
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|integer",
            "area" => "required|integer",
            "adult" => "required|integer",
            "children" => "required|integer",
            "description" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $room = new Room();
        $room->name = $request->name;
        $room->price = $request->price;
        $room->quantity = $request->quantity;
        $room->area = $request->area;
        $room->adult = $request->adult;
        $room->children = $request->children;
        $room->description = $request->description;
        $room->save();
        return $this->send_response(message: "New Room successfully created .", status_code: 201);
    }

    // show single room
    public function show($id)
    {
        $results["room"] = Room::find($id);
        return $this->send_response(message: "Room data .", results: $results);
    }

    // update room record
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|integer",
            "area" => "required|integer",
            "adult" => "required|integer",
            "children" => "required|integer",
            "description" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $room = Room::find($id);
        $room->name = $request->name;
        $room->price = $request->price;
        $room->quantity = $request->quantity;
        $room->area = $request->area;
        $room->adult = $request->adult;
        $room->children = $request->children;
        $room->description = $request->description;
        $room->save();
        return $this->send_response(message: "Room record successfully updated .");
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
        return $this->send_response(message: $message);
    }

    // delete room record
    public function delete($id)
    {
        $room = Room::find($id);
        if (!is_null($room)) {
            $room->delete();
            return $this->send_response(message: "Room successfully deleted .");
        }
    }
}
