<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    // show all facility
    public function index()
    {
        $facilities = Facility::all();
        return response([
            "success" => true,
            "facilities" => $facilities
        ]);
    }

    // create a new facility
    public function create(Request $request)
    {
        $request->validate([
            "image" => "required|image|max:1024|mimes:svg,jpg,jpeg,png,webp",
            "name" => "required|string",
            "description" => "required|string"
        ]);

        $image = $request->image->store("image/facility", "public");

        $facility = new Facility();
        $facility->image = $image;
        $facility->name = $request->name;
        $facility->description = $request->description;
        $facility->save();

        return response([
            "success" => true,
            "message" => "New facility successfully created ."
        ], 201);
    }

    // show single facility record
    public function show($id)
    {
        $facility = Facility::find($id);
        return response([
            "success" => true,
            "facility" => $facility
        ]);
    }

    // update facility record
    public function update(Request $request, $id)
    {
        $request->validate([
            "image" => "nullable|image|max:1024|mimes:svg,jpg,jpeg,png,webp",
            "name" => "required|string",
            "description" => "required|string"
        ]);

        $facility = Facility::find($id);

        // if find a new image then delete old image
        if ($request->hasFile("image")) {
            $old_image = public_path("storage/") . $facility->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }

            $new_image = $request->image->store("image/facility", "public");
            $facility->image = $new_image;
        }

        $facility->name = $request->name;
        $facility->description = $request->description;
        $facility->save();

        return response([
            "success" => true,
            "message" => "Facility record successfully updated ."
        ]);
    }

    // delete facility record
    public function delete($id)
    {
        $facility = Facility::find($id);
        if (!is_null($facility)) {
            $image = public_path("storage/") . $facility->image;
            if (file_exists($image)) {
                @unlink($image);
            }
            $facility->delete();
            return response([
                "success" => true,
                "message" => "Facility record successfully deleted ."
            ]);
        }
    }
}
