<?php

namespace App\Http\Controllers\VisitiorPanel;

use App\Http\Controllers\BaseController;
use App\Models\Carousel;


class CarouselController extends BaseController
{
    // show all crousel image record
    public function index()
    {
        $results["carousel"] = Carousel::all();
        return $this->send_response(message: "Carousel Data .", results: $results);
    }
}
