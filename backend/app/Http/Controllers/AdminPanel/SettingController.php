<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends BaseController
{
    // show settings
    public function index()
    {
        $results["setting"] = Setting::first();
        return $this->send_response(message: "Settings data.", results: $results);
    }

    // change web shutdown status
    public function shutdown()
    {
        $setting = Setting::first();

        if ($setting->shutdown) {
            $setting->shutdown = 0;
            $message = "The web application is running .";
        } else {
            $setting->shutdown = 1;
            $message = "The web application is under maintenance.";
        }

        $setting->save();
        return $this->send_response(message: $message);
    }

    // update the web descrition
    public function update(Request $request)
    {
        $validation = Validator::make($request->all, [
            "description" => "required|string"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $setting = Setting::first();

        if (!is_null($setting)) {
            $setting->description = $request->description;
            $setting->save();
            return $this->send_response(message: "The web description successfully updated .");
        }

        // if settings table is empty then create first the web description
        $setting = new Setting();
        $setting->description = $request->description;
        $setting->save();
        return $this->send_response(message: "The web description successfully created .", status_code: 201);
    }
}
