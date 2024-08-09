<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use app\Models\Information;

class AddressController extends BaseController
{
    // show company information
    public function index()
    {
        $results["company_information"] = Information::first();
        return $this->send_response(message: "Company information .", results: $results);
    }
}
