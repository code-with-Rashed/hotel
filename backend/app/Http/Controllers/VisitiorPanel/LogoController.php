<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Logo;

class LogoController extends BaseController
{
    // response logo
    public function index()
    {
        $results["logo"] = Logo::first();
        return $this->send_response(message: "Logo .", results: $results);
    }
}
