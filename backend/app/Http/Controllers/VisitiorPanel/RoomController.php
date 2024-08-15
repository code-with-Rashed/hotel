<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Room;

class RoomController extends BaseController
{
    // response all room
    public function all_room()
    {
        $results["rooms"] = Room::with(['features:name', 'facilities:name', 'images' => function ($query) {
            $query->select('image', 'room_id')->where('thumbnail', 1);
        }])->where('status', 0)->get();
        return $this->send_response(message: "Room details.", results: $results);
    }

    // response single room related data
    public function room($id)
    {
        $results["room"] = Room::with(['features:name', 'facilities:name', 'images:image,room_id'])->find($id);
        return $this->send_response(message: "Room details.", results: $results);
    }

    // response confirm room related data
    public function confirm_room($id)
    {
        $results["room"] = Room::with(['images' => function ($query) {
            $query->select('image', 'room_id')->where('thumbnail', 1);
        }])->select('id', 'name', 'price')->find($id);
        return $this->send_response(message: "Room details.", results: $results);
    }
}
