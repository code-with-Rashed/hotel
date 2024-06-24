<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AdminController extends Controller
{
    // Admin profile login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response([
                'success' => false,
                'message' => 'Invalid login details !'
            ], 401);
        }
        $token = $admin->createToken('admin_auth_token')->plainTextToken;
        return response([
            'success' => true,
            'admin' => $admin,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    // Admin profile logout
    public function logout(Request $request)
    {
        $id = explode('|', $request->bearerToken())[0];
        PersonalAccessToken::where('id', $id)->delete();
        return response([
            'success' => true,
            'message' => 'You have been successfully logged out!',
        ], 200);
    }

    // Admin profile update
    public function update_profile(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "photo" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
            "email" => "required|email|unique:admins,email,$id"
        ]);

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

        return response([
            'success' => true,
            'message' => 'Profile successfully updated !',
        ], 200);
    }

    // Admin profile password update
    public function update_password(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $admin = Admin::find($id);

        if (!Hash::check($request->old_password, $admin->password)) {
            return response([
                'success' => false,
                'message' => 'Invalid Old Password !'
            ], 401);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response([
            'success' => true,
            'message' => 'Password successfully updated !',
        ], 200);
    }
}
