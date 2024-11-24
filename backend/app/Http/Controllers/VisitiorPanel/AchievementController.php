<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Achievement;
use Illuminate\Support\Facades\Cache;

class AchievementController extends BaseController
{
    // show team members
    public function index()
    {
        $results["achievement"] = Cache::rememberForever("achievement", function () {
            return Achievement::all();
        });
        return $this->send_response(message: "Achievement record .", results: $results);
    }
}
