<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AdminController extends BaseController
{
    // Admin profile login
    public function login(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return $this->send_error(message: "Invalid login details !", status_code: 401);
        }
        $token = $admin->createToken('admin_auth_token')->plainTextToken;
        $results = [
            'admin' => $admin,
            'admin_access_token' => $token,
            'token_type' => 'Bearer'
        ];
        return $this->send_response(message: "Authentication successfull .", results: $results);
    }

    // Admin profile logout
    public function logout(Request $request)
    {
        $id = explode('|', $request->bearerToken())[0];
        PersonalAccessToken::where('id', $id)->delete();

        return $this->send_response(message: "You have been successfully logged out .");
    }

    // Admin profile update
    public function update_profile(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
            "photo" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
            "email" => "required|email|unique:admins,email,$id"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('photo')) {

            $image_path = public_path('storage/') . $admin->photo;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }

            $photo_path = $request->photo->store('image/admin_photo', 'public');
            $admin->photo = $photo_path;
        }

        $admin->save();
        return $this->send_response(message: "Profile information successfully updated !");
    }

    // Admin profile password update
    public function update_password(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $admin = Admin::find($id);

        if (!Hash::check($request->old_password, $admin->password)) {
            return $this->send_error(message: "Invalid Old Password !");
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return $this->send_response(message: "Password successfully updated !");
    }
}
