<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Information;
use Illuminate\Support\Facades\Cache;

class AddressController extends BaseController
{
    // show company information
    public function index()
    {
        $results["company_information"] = Cache::rememberForever("company_information", function () {
            return Information::first();
        });
        return $this->send_response(message: "Company information .", results: $results);
    }
}
