<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    // show all crousel image record
    public function index()
    {
        $carousel = Carousel::all();
        return response([
            "success" => true,
            "carousel" => $carousel
        ], 200);
    }

    // create & upload a new carousel image
    public function create(Request $request)
    {
        $request->validate([
            "image" => "required|image|mimes:jpg,jpeg,png,webp|max:3072"
        ]);

        $image_path = $request->image->store("image/carousel", "public");
        $carousel = new Carousel();
        $carousel->image = $image_path;
        $carousel->save();

        return response([
            "success" => true,
            "message" => "New carousel image successfully created ."
        ], 201);
    }

    // update & upload crousel image 
    public function update(Request $request, $id)
    {
        $request->validate([
            "image" => "required|image|mimes:jpg,jpeg,png,webp|max:3072"
        ]);

        $carousel = Carousel::find($id);

        $old_image_path = public_path("storage/") . $carousel->image;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }

        $image_path = $request->image->store("image/carousel", "public");

        $carousel->image = $image_path;
        $carousel->save();


        return response([
            'success' => true,
            'message' => 'Carousel image successfully updated !',
        ], 200);
    }

    // delete & unlinnk carousel image
    public function delete($id)
    {
        $carousel = Carousel::find($id);
        if (!is_null($carousel)) {
            $image_path = public_path("storage/") . $carousel->image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $carousel->delete();
        }

        return response([
            'success' => true,
            'message' => 'Carousel image successfully deleted !',
        ], 200);
    }
}
