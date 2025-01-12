<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeatureController extends BaseController
{
    // show room features
    public function index()
    {
        $results["features"] = Feature::all();
        return $this->send_response(message: "Features data.", results: $results);
    }

    // create a new room feature
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "Validation error!", errors: $validation->errors()->all());
        }

        $feature = new Feature();
        $feature->name = $request->name;
        $feature->save();
        return $this->send_response(message: "New feature successfully created.", status_code: 201);
    }

    // show single feature record
    public function show($id)
    {
        $results["feature"] = Feature::find($id);
        return $this->send_response(message: "Feature data.", results: $results);
    }

    // update room feature
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "Validation error!", errors: $validation->errors()->all());
        }

        $feature = Feature::find($id);
        $feature->name = $request->name;
        $feature->save();
        return $this->send_response(message: "Feature successfully updated.");
    }

    // delete room feature
    public function delete($id)
    {
        $feature = Feature::find($id);
        if (!is_null($feature)) {
            $feature->delete();
            return $this->send_response(message: "Feature successfully deleted.");
        }
    }
}
