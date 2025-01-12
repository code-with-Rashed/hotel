<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Logo;
use Illuminate\Support\Facades\Cache;

class LogoController extends BaseController
{
    // response logo
    public function index()
    {
        $results["logo"] = Cache::rememberForever("logo", function () {
            return Logo::first();
        });
        return $this->send_response(message: "The logo.", results: $results);
    }
}
