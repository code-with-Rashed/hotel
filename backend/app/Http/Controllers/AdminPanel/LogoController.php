<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    // show logo
    public function index()
    {
        $logo = Logo::first();
        return response([
            "success" => true,
            "logo" => $logo
        ], 200);
    }

    // update logo
    public function update(Request $request)
    {
        $request->validate([
            "logo" => "required|image|max:2048|mimes:jpg,jpeg,png,webp,svg"
        ]);

        $new_logo = $request->logo->store("image/logo", "public");

        $logo = Logo::first();

        if (!is_null($logo)) {
            $old_logo = public_path("storage/") . $logo->logo;
            if (file_exists($old_logo)) {
                @unlink($old_logo);
            }
            $logo->logo = $new_logo;
            $logo->save();

            return response([
                "success" => true,
                "message" => "Logo successfully updated ."
            ]);
        }

        // if logo table is empty then create & upload first logo
        $logo = new Logo();
        $logo->logo = $new_logo;
        $logo->save();

        return response([
            "success" => true,
            "message" => "Logo successfully created ."
        ]);
    }
}
