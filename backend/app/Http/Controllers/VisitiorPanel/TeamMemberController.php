<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Team;

class TeamMemberController extends BaseController
{
    // show team members
    public function index()
    {
        $results["team"] = Team::all();
        return $this->send_response(message: "Team members data .", results: $results);
    }
}
