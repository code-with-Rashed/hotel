<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // show team members
    public function index()
    {
        $team = Team::all();
        return response([
            "success" => true,
            "team" => $team
        ]);
    }

    // create a new team member
    public function create(Request $request)
    {
        $request->validate([
            "photo" => "required|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
            "name" => "required|string",
            "designation" => "required|string"
        ]);

        $photo = $request->photo->store("image/team", "public");

        $team = new Team();
        $team->photo = $photo;
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->save();

        return response([
            "success" => true,
            "message" => "New team member successfully created ."
        ], 201);
    }

    // show single team record
    public function show($id)
    {
        $team = Team::find($id);
        return response([
            "success" => true,
            "team" => $team
        ]);
    }

    // update team record
    public function update(Request $request, $id)
    {
        $request->validate([
            "photo" => "nullable|image|max:2048|mimes:jpg,jpeg,png,webp,svg",
            "name" => "required|string",
            "designation" => "required|string"
        ]);

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

        return response([
            "success" => true,
            "message" => "Team member record successfully updated ."
        ]);
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

            return response([
                "success" => true,
                "message" => "Team member record successfully deleted ."
            ]);
        }
    }
}
