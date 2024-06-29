<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\RoomFacility;
use App\Models\RoomFeature;
use Illuminate\Http\Request;

class RoomFeatureFacilityController extends Controller
{
    // show room related saved features id
    public function get_room_features_id($room_id)
    {
        $room_features = RoomFeature::where("room_id", $room_id)->get();
        return response([
            "success" => true,
            "room_features" => $room_features
        ]);
    }

    // show room related saved facilities id
    public function get_room_facilities_id($room_id)
    {
        $room_facilities = RoomFacility::where("room_id", $room_id)->get();
        return response([
            "success" => true,
            "room_facilities" => $room_facilities
        ]);
    }

    // save room related feature & facility id
    public function create(Request $request)
    {
        $request->validate([
            "room_id" => "required|integer|exists:rooms,id",
            "feature_id" => "required|array",
            "facility_id" => "required|array",
            "feature_id.*" => "required|integer|exists:features,id",
            "facility_id.*" => "required|integer|exists:facilities,id",
        ]);

        foreach ($request->feature_id as $id) {
            $room_feature = new RoomFeature();
            $room_feature->room_id = $request->room_id;
            $room_feature->feature_id = $id;
            $room_feature->save();
        }

        foreach ($request->facility_id as $id) {
            $room_facility = new RoomFacility();
            $room_facility->room_id = $request->room_id;
            $room_facility->facility_id = $id;
            $room_facility->save();
        }

        return response([
            "success" => true,
            "message" => "Hotel Room related feature & facility successfully saved ."
        ], 201);
    }

    // update room related feature & facility id
    public function update(Request $request)
    {
        $request->validate([
            "room_id" => "required|integer|exists:rooms,id",
            "feature_id" => "required|array",
            "facility_id" => "required|array",
            "feature_id.*" => "required|integer|exists:features,id",
            "facility_id.*" => "required|integer|exists:facilities,id",
        ]);

        foreach ($request->feature_id as $id) {
            RoomFeature::updateOrInsert(
                ["room_id" => $request->room_id, "feature_id" => $id],
                ["room_id" => $request->room_id, "feature_id" => $id, "created_at" => now(), "updated_at" => now()]
            );
        }

        foreach ($request->facility_id as $id) {
            RoomFacility::updateOrInsert(
                ["room_id" => $request->room_id, "facility_id" => $id],
                ["room_id" => $request->room_id, "facility_id" => $id, "created_at" => now(), "updated_at" => now()],
            );
        }

        $this->delete($request->room_id, $request->feature_id, $request->facility_id);

        return response([
            "success" => true,
            "message" => "Hotel Room related feature & facility successfully updated ."
        ]);
    }

    // non used room feature & facility id delete
    protected function delete(int $room_id, array $feature_id, array $facility_id)
    {
        $room_features = RoomFeature::where("room_id", $room_id)->whereNotIn("feature_id", $feature_id)->get();
        $room_facilities = RoomFacility::where("room_id", $room_id)->whereNotIn("facility_id", $facility_id)->get();

        foreach ($room_features as $room_feature) {
            RoomFeature::destroy($room_feature->id);
        }
        foreach ($room_facilities as $room_facility) {
            RoomFacility::destroy($room_facility->id);
        }
    }
}
