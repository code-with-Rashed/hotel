<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class TeamMemberController extends BaseController
{
    // show team members
    public function index()
    {
        $results["team"] = Cache::rememberForever("team", function () {
            return Team::all();
        });
        return $this->send_response(message: "Team member's data.", results: $results);
    }
}
