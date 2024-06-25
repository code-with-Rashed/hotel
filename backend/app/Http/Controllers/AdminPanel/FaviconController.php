<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Favicon;
use Illuminate\Http\Request;

class FaviconController extends Controller
{
    // show favicon
    public function index()
    {
        $favicon = Favicon::all();
        return response([
            "success" => true,
            "favicons" => $favicon
        ], 200);
    }

    // update favicon
    public function update(Request $request)
    {
        $request->validate([
            "icon" => "required|image|max:1024|mimes:jpg,jpeg,png,svg,webp"
        ]);

        $new_favicon = $request->icon->store("image/favicon", "public");

        $favicon = Favicon::first();

        if (!is_null($favicon)) {

            $old_favicon = public_path("storage/") . $favicon->icon;
            if (file_exists($old_favicon)) {
                @unlink($old_favicon);
            }

            $favicon->icon = $new_favicon;
            $favicon->save();

            return response([
                'success' => true,
                'message' => 'Favicon successfully updated !',
            ], 200);
        }

        // if favicon table is empty then create & upload first favicon
        $favicon = new Favicon();
        $favicon->icon = $new_favicon;
        $favicon->save();

        return response([
            'success' => true,
            'message' => 'Favicon successfully created !',
        ], 200);
    }
}
