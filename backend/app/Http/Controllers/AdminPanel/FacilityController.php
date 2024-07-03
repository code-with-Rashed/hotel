<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacilityController extends BaseController
{
    // show all facility
    public function index()
    {
        $results["facilities"] = Facility::all();
        return $this->send_response(message: "Facility data .", results: $results);
    }

    // create a new facility
    public function create(Request $request)
    {
        $validation = Validator::make($request->all, [
            "image" => "required|image|max:1024|mimes:svg,jpg,jpeg,png,webp",
            "name" => "required|string",
            "description" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $image = $request->image->store("image/facility", "public");

        $facility = new Facility();
        $facility->image = $image;
        $facility->name = $request->name;
        $facility->description = $request->description;
        $facility->save();
        return $this->send_response(message: "New facility successfully created .", status_code: 201);
    }

    // show single facility record
    public function show($id)
    {
        $results["facility"] = Facility::find($id);
        return $this->send_response(message: "Facility data .", results: $results);
    }

    // update facility record
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all, [
            "image" => "nullable|image|max:1024|mimes:svg,jpg,jpeg,png,webp",
            "name" => "required|string",
            "description" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

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
        return $this->send_response(message: "Facility record successfully updated .");
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
            return $this->send_response(message: "Facility record successfully deleted .");
        }
    }
}
