<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Facility;

class FacilityController extends BaseController
{
     // response all facility record
     public function index()
     {
         $results["facilities"] = Facility::all();
         return $this->send_response(message: "Facility data .", results: $results);
     }   
}
