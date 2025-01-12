<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Carousel;
use Illuminate\Support\Facades\Cache;

class CarouselController extends BaseController
{
    // show all crousel image record
    public function index()
    {
        $results["carousel"] = Cache::rememberForever("carousel", function () {
            return Carousel::all();
        });
        return $this->send_response(message: "Carousel data.", results: $results);
    }
}
