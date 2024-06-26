<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // show settings
    public function index()
    {
        $setting = Setting::first();
        return response([
            "success" => true,
            "setting" => $setting
        ], 200);
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

        return response([
            "success" => true,
            "message" => $message,
        ]);
    }

    // update the web descrition
    public function update(Request $request)
    {
        $request->validate([
            "description" => "required|string"
        ]);

        $setting = Setting::first();

        if (!is_null($setting)) {
            $setting->description = $request->description;
            $setting->save();

            return response([
                'success' => true,
                'message' => 'The web description successfully updated !',
            ]);
        }

        // if settings table is empty then create first the web description
        $setting = new Setting();
        $setting->description = $request->description;
        $setting->save();

        return response([
            'success' => true,
            'message' => 'The web description successfully created !',
        ]);
    }
}
