<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Favicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaviconController extends BaseController
{
    // show favicon
    public function index()
    {
        $results["favicon"] = Favicon::first();
        return $this->send_response(message: "Favicon .", results: $results);
    }

    // update favicon
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "icon" => "required|image|max:1024|mimes:jpg,jpeg,png,svg,webp"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $new_favicon = $request->icon->store("image/favicon", "public");

        $favicon = Favicon::first();

        if (!is_null($favicon)) {

            $old_favicon = public_path("storage/") . $favicon->getRawOriginal('icon');
            if (file_exists($old_favicon)) {
                @unlink($old_favicon);
            }

            $favicon->icon = $new_favicon;
            $favicon->save();
            return $this->send_response(message: "Favicon successfully updated .");
        }

        // if favicon table is empty then create & upload first favicon
        $favicon = new Favicon();
        $favicon->icon = $new_favicon;
        $favicon->save();
        return $this->send_response(message: "Favicon successfully created .", status_code: 201);
    }
}
