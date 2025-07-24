<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Favicon;
use Illuminate\Support\Facades\Cache;

class FaviconController extends BaseController
{
    // response favicon
    public function index()
    {
        $results["favicon"] = Cache::rememberForever("favicon", function () {
            return Favicon::first();
        });
        return $this->send_response(message: "The Favicon.", results: $results);
    }
}
