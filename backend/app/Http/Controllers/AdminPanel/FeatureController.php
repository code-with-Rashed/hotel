<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    // show room features
    public function index()
    {
        $features = Feature::all();
        return response([
            "success" => true,
            "features" => $features,
        ], 200);
    }

    // create a new room feature
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required|string"
        ]);

        $feature = new Feature();
        $feature->name = $request->name;
        $feature->save();

        return response([
            "success" => true,
            "message" => "New feature successfully created .",
        ], 201);
    }

    // update room feature
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string"
        ]);

        $feature = Feature::find($id);
        $feature->name = $request->name;
        $feature->save();

        return response([
            "success" => true,
            "message" => "Feature successfully updated .",
        ], 200);
    }

    // delete room feature
    public function delete($id)
    {
        $feature = Feature::find($id);
        if (!is_null($feature)) {
            $feature->delete();
            return response([
                "success" => true,
                "message" => "Feature successfully deleted .",
            ], 200);
        }
    }
}
