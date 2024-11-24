<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AchievementController extends BaseController
{
    // show achievement
    public function index()
    {
        $results["achievement"] = Achievement::all();
        return $this->send_response(message: "Achievement data .", results: $results);
    }

    // create a new achievement record
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "achievement" => "required|string",
            "photo" => "required|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $photo = $request->photo->store("image/achievement", "public");

        $achievement = new Achievement();
        $achievement->photo = $photo;
        $achievement->achievement = $request->achievement;
        $achievement->save();
        Cache::forget("achievement");
        return $this->send_response(message: "New achievement record successfully created .", status_code: 201);
    }

    // show single achievement record
    public function show($id)
    {
        $results["achievement"] = Achievement::find($id);
        return $this->send_response(message: "Achievement data .", results: $results);
    }

    // update achievement record
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "achievement" => "required|string",
            "photo" => "nullable|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $achievement = Achievement::find($id);

        // if find a new photo then delete old photo
        if ($request->hasFile("photo")) {
            $old_photo = public_path("storage/") . $achievement->getRawOriginal('photo');
            if (file_exists($old_photo)) {
                @unlink($old_photo);
            }

            $new_photo = $request->photo->store("image/achievement", "public");
            $achievement->photo = $new_photo;
        }

        $achievement->achievement = $request->achievement;
        $achievement->save();
        Cache::forget("achievement");
        return $this->send_response(message: "Achievement record successfully updated .");
    }

    // delete achievement record
    public function delete($id)
    {
        $achievement = Achievement::find($id);
        if (!is_null($achievement)) {
            $photo = public_path("storage/") . $achievement->getRawOriginal('photo');
            if (file_exists($photo)) {
                @unlink($photo);
            }
            $achievement->delete();
            Cache::forget("achievement");
            return $this->send_response(message: "Achievement record successfully deleted .");
        }
    }
}
