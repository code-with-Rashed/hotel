<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends BaseController
{
    // response all room
    public function all_room()
    {
        $results["rooms"] = Room::with(['features:name', 'facilities:name', 'images' => function ($query) {
            $query->select('image', 'room_id')->where('thumbnail', 1);
        }])->withAvg('rating_review', 'star')->where('status', 0)->paginate(3);
        return $this->send_response(message: "Room details.", results: $results);
    }

    // response filtered rooms
    public function filtered_room(Request $request)
    {
        $checkin = $request->checkin ?? '';
        $checkout =  $request->checkout ?? '';
        $adult = $request->adult ?? 0;
        $children = $request->children ?? 0;
        $facilities = $request->facilities ?? [];
        $query = Room::with([
            'features:name',
            'facilities:name',
            'images' => function ($query) {
                $query->select('image', 'room_id')->where('thumbnail', 1);
            }
        ])->withAvg('rating_review', 'star')->where('status', 0);
        if ($checkin && $checkout) {
            $query = $query->withCount(['booking_orders' => function ($subquery) use ($checkin, $checkout) {
                $subquery->where([['booking_status', 'booked'], ['checkin', '<', $checkout], ['checkout', '>', $checkin]]);
            }]);
        }
        if (!empty($facilities)) {
            $query = $query->whereHas('facilities', function ($subquery) use ($facilities) {
                $subquery->select('name')->whereIn('facility_id', $facilities);
            });
        }
        if ($adult > 0) {
            $query = $query->where('rooms.adult', $adult);
        }
        if ($children > 0) {
            $query = $query->orWhere('rooms.children', $children);
        }
        $results['rooms'] = $query->paginate(3);
        return $this->send_response(message: "Room details.", results: $results);
    }

    // response maximum adult & children number
    public function max()
    {
        $results["adult"] = Room::max('adult');
        $results["children"] = Room::max('children');
        return $this->send_response(message: "Maximum adults & children stay in one room at the same time.", results: $results);
    }

    // response single room related data
    public function room($id)
    {
        $results["room"] = Room::with(['features:name', 'facilities:name', 'images:image,room_id'])->withAvg('rating_review', 'star')->find($id);
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
