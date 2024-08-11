<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Setting;

class SettingController extends BaseController
{
    // response settings record
    public function index()
    {
        $results["setting"] = Setting::first();
        return $this->send_response(message: "Settings data.", results: $results);
    }
}
