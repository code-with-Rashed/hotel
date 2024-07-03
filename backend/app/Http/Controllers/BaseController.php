<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    public function send_response($message, $results = null, $status_code = 200)
    {
        $response = [
            "success" => true,
            "message" => $message,
        ];
        if (!is_null($results)) {
            $response["data"] = $results;
        }
        return response()->json($response, $status_code);
    }
    public function send_error($message, $errors = [], $status_code = 400)
    {
        $response = [
            "success" => true,
            "message" => $message,
        ];
        if (!empty($errors)) {
            $response["data"] = $errors;
        }
        return response()->json($response, $status_code);
    }
}
