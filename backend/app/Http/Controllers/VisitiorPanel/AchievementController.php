<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Achievement;

class AchievementController extends BaseController
{
    // show team members
    public function index()
    {
        $results["achievement"] = Achievement::all();
        return $this->send_response(message: "Achievement record .", results: $results);
    }
}
