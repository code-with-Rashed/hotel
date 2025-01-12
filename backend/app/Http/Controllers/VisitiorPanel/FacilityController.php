<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Facility;
use Illuminate\Support\Facades\Cache;

class FacilityController extends BaseController
{
     // response all facility record
     public function index()
     {
         $results["facilities"] = Cache::rememberForever("facilities",function(){
            return Facility::all();
         });
         return $this->send_response(message: "Facility data.", results: $results);
     }   
}
