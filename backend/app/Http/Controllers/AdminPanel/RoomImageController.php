<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomImageController extends BaseController
{
    // show room images for related hotel room
    public function get_image($room_id)
    {
        $results["images"] = RoomImage::where("room_id", $room_id)->get();
        return $this->send_response(message: "Room images .", results: $results);
    }

    // create & upload room image & record
    public function create(Request $request)
    {
        $validation = Validator::make($request->all, [
            "room_id" => "required|integer|exists:rooms,id",
            "image" => "required|image|max:2048|mimes:jpg,jpeg,png,webp"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $image = $request->image->store("image/rooms", "public");

        $room_image = new RoomImage();
        $room_image->room_id = $request->room_id;
        $room_image->image = $image;
        $room_image->save();
        return $this->send_response(message: "The room image successfully created .", status_code: 201);
    }

    // update & upload room image & record
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all, [
            "image" => "required|image|max:2048|mimes:jpg,jpeg,png,webp"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $room_image = RoomImage::find($id);

        if (!is_null($room_image)) {

            // if upload a new image then delete old image
            $old_image = public_path("storage/") . $room_image->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }

            $image = $request->image->store("image/rooms", "public");
            $room_image->image = $image;
            $room_image->save();
            return $this->send_response(message: "The room image successfully updated .");
        }
        return $this->send_error(message: "This room image record is not found .");
    }

    // change thumbnail status
    public function thumbnail($id)
    {
        $room_image = RoomImage::find($id);

        if (!is_null($room_image)) {
            if ($room_image->thumbnail) {
                $room_image->thumbnail = 0;
                $room_image->save();
                return $this->send_response(message: "This room image is not a thumbnail image right now .");
            } else {
                $room_image->thumbnail = 1;
                $room_image->save();
                return $this->send_response(message: "This room image is a thumbnail image right now .");
            }
        }
        return $this->send_error(message: "This room image record is not found .");
    }

    // delete room image
    public function delete($id)
    {
        $room_image = RoomImage::find($id);
        if (!is_null($room_image)) {

            // delete room image from folder
            $old_image = public_path("storage/") . $room_image->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }

            $room_image->delete();
            return $this->send_response(message: "This room image successfully deleted .");
        }
    }
}
