<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends BaseController
{
    // user registration
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string|max:50",
            "email" => "required|email|max:70|unique:users,email",
            "password" => "required|confirmed",
            "number" => "required|max:15",
            "pincode" => "required",
            "address" => "required",
            "dob" => "required|date",
            "photo" => "required|image|mimes:png,jpg,jpeg,webp|max:2048",
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->number = $request->number;
        $user->pincode = $request->pincode;
        $user->dob = Carbon::createFromFormat('Y-m-d', $request->dob);
        $user->address = $request->address;
        $photo_path = $request->photo->store('image/user_photo', 'public'); // upload user profile photo
        $user->photo = $photo_path;
        $user->save();
        return $this->send_response(message: "Registration successfull. Please Login your account.", status_code: 201);
    }

    // user login
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|email|max:70",
            "password" => "required"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->send_error(message: "Invalid login details !", status_code: 401);
        }
        $results = [
            'user' => $user,
            'user_access_token' => $user->createToken('user_auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ];
        return $this->send_response(message: "Authentication successfull .", results: $results);
    }

    // logout user
    public function logout(Request $request)
    {
        $id = explode('|', $request->bearerToken())[0];
        PersonalAccessToken::where('id', $id)->delete();
        return $this->send_response(message: "You have been successfully logged out .");
    }

    // update user profile
    public function profile_update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string|max:50",
            "email" => "required|email|max:70|unique:users,email,$id",
            "number" => "required|max:15",
            "pincode" => "required",
            "address" => "required",
            "dob" => "required|date"
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->pincode = $request->pincode;
        $user->dob = Carbon::createFromFormat('Y-m-d', $request->dob);
        $user->address = $request->address;
        $user->save();

        return $this->send_response(message: "Profile successfully Updated.", status_code: 200);
    }

    public function update_photo(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "photo" => "required|image|mimes:png,jpg,jpeg,webp|max:2048",
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }
        $user = User::find($id);
        // remove old user photo
        $old_path = public_path('storage/') . $user->getRawOriginal('photo');
        if (file_exists($old_path)) {
            @unlink($old_path);
        }
        //---------------------
        $photo_path = $request->photo->store('image/user_photo', 'public'); // upload user profile photo
        $user->photo = $photo_path;
        $user->save();
        return $this->send_response(message: "Profile photo successfully Updated.", results: ['photo' => $user->photo], status_code: 200);
    }

    // update user profile password
    public function update_password(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validation->fails()) {
            return $this->send_error(message: "validation error", errors: $validation->errors()->all());
        }

        $user = User::find($id);

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->send_error(message: "Invalid Old Password !");
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $this->send_response(message: "Password successfully updated !");
    }
}
