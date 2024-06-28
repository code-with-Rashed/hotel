<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\RoomImage;
use Illuminate\Http\Request;

class RoomImageController extends Controller
{
    // show room images for related hotel room
    public function get_image($room_id)
    {
        $room_images = RoomImage::where("room_id", $room_id)->get();
        return response([
            "success" => true,
            "images" => $room_images
        ]);
    }

    // create & upload room image & record
    public function create(Request $request)
    {
        $request->validate([
            "room_id" => "required|integer|exists:rooms,id",
            "image" => "required|image|max:2048|mimes:jpg,jpeg,png,webp"
        ]);

        $image = $request->image->store("image/rooms", "public");

        $room_image = new RoomImage();
        $room_image->room_id = $request->room_id;
        $room_image->image = $image;
        $room_image->save();

        return response([
            "success" => true,
            "message" => "The room image successfully created ."
        ], 201);
    }

    // update & upload room image & record
    public function update(Request $request, $id)
    {
        $request->validate([
            "image" => "required|image|max:2048|mimes:jpg,jpeg,png,webp"
        ]);

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

            return response([
                "success" => true,
                "message" => "The room image successfully updated ."
            ]);
        }

        return response([
            "success" => false,
            "message" => "The room image record is not found ."
        ], 400);
    }

    // change thumbnail status
    public function thumbnail($id)
    {
        $room_image = RoomImage::find($id);

        if (!is_null($room_image)) {
            if ($room_image->thumbnail) {
                $room_image->thumbnail = 0;
                $room_image->save();
                return response([
                    "success" => true,
                    "message" => "This room image is not a thumbnail image right now ."
                ]);
            } else {
                $room_image->thumbnail = 1;
                $room_image->save();
                return response([
                    "success" => true,
                    "message" => "This room image is a thumbnail image right now ."
                ]);
            }
        }
        return response([
            "success" => false,
            "message" => "The room image record is not found ."
        ], 400);
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

            return response([
                "success" => true,
                "message" => "The room image successfully deleted ."
            ]);
        }
    }
}
