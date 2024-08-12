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
}
