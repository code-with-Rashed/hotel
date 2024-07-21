<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogoController extends BaseController
{
    // show logo
    public function index()
    {
        $results["logo"] = Logo::first();
        return $this->send_response(message: "Logo .", results: $results);
    }

    // update logo
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "logo" => "required|image|max:2048|mimes:jpg,jpeg,png,webp,svg"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        // upload logo
        $new_logo = $request->logo->store("image/logo", "public");

        $logo = Logo::first();
        if (!is_null($logo)) {
            $old_logo = public_path("storage/") . $logo->getRawOriginal('logo');
            if (file_exists($old_logo)) {
                @unlink($old_logo);
            }
            $logo->logo = $new_logo;
            $logo->save();
            return $this->send_response(message: "Logo successfully updated .");
        }

        // if logo table is empty then create & upload first logo
        $logo = new Logo();
        $logo->logo = $new_logo;
        $logo->save();
        return $this->send_response(message: "Logo successfully created .", status_code: 201);
    }
}
