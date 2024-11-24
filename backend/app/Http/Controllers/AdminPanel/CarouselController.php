<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CarouselController extends BaseController
{
    // show all crousel image record
    public function index()
    {
        $results["carousel"] = Carousel::all();
        return $this->send_response(message: "Carousel Data .", results: $results);
    }

    // create & upload a new carousel image
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "image" => "required|image|mimes:jpg,jpeg,png,webp|max:3072"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $image_path = $request->image->store("image/carousel", "public");
        $carousel = new Carousel();
        $carousel->image = $image_path;
        $carousel->save();
        Cache::forget("carousel");
        return $this->send_response(message: "New carousel image successfully created .", status_code: 201);
    }

    // show single carousel record
    public function show($id)
    {
        $results["carousel"] = Carousel::find($id);
        return $this->send_response(message: "Carousel data .", results: $results);
    }

    // update & upload crousel image 
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "image" => "required|image|mimes:jpg,jpeg,png,webp|max:3072"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $carousel = Carousel::find($id);

        $old_image_path = public_path("storage/") . $carousel->getRawOriginal('image');
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }

        $image_path = $request->image->store("image/carousel", "public");

        $carousel->image = $image_path;
        $carousel->save();
        Cache::forget("carousel");
        return $this->send_response(message: "Carousel image successfully updated .");
    }

    // delete & unlinnk carousel image
    public function delete($id)
    {
        $carousel = Carousel::find($id);
        if (!is_null($carousel)) {
            $image_path = public_path("storage/") . $carousel->getRawOriginal('image');
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $carousel->delete();
            Cache::forget("carousel");
        }
        return $this->send_response(message: "Carousel image successfully deleted .");
    }
}
