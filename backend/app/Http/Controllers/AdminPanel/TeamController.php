<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends BaseController
{
    // show team members
    public function index()
    {
        $results["team"] = Team::all();
        return $this->send_response(message: "Team members data .", results: $results);
    }

    // create a new team member
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "photo" => "required|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
            "name" => "required|string",
            "designation" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $photo = $request->photo->store("image/team", "public");

        $team = new Team();
        $team->photo = $photo;
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->save();
        return $this->send_response(message: "New team member successfully created .", status_code: 201);
    }

    // show single team record
    public function show($id)
    {
        $results["team"] = Team::find($id);
        return $this->send_response(message: "Team member data .", results: $results);
    }

    // update team record
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "photo" => "nullable|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
            "name" => "required|string",
            "designation" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $team = Team::find($id);

        // if find a new photo then delete old photo
        if ($request->hasFile("photo")) {
            $old_photo = public_path("storage/") . $team->photo;
            if (file_exists($old_photo)) {
                @unlink($old_photo);
            }

            $new_photo = $request->photo->store("image/team", "public");
            $team->photo = $new_photo;
        }

        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->save();
        return $this->send_response(message: "Team member record successfully updated .");
    }

    // delete team record
    public function delete($id)
    {
        $team = Team::find($id);
        if (!is_null($team)) {
            $photo = public_path("storage/") . $team->photo;
            if (file_exists($photo)) {
                @unlink($photo);
            }
            $team->delete();
            return $this->send_response(message: "Team member record successfully deleted .");
        }
    }
}
