<?php

namespace App\Helpers;

class ResponsesHelper
{
    public static function success($message, $code = 200, $data = null)
    {
        $successResponse = [
            'message' => $message,
        ];

        if (!is_null($data)) {
            $successResponse['data'] = $data;
        }

        return response()->json($successResponse, $code);
    }

    public static function error($message, $code = 400, $error = null)
    {
        $errorResponse = [
            'message' => $message,
        ];

        if (!is_null($error)) {
            $errorResponse['error'] = $error;
        }

        return response()->json($errorResponse, $code);
    }


    public static function validationErrors($validation_errors)
    {
        return ResponsesHelper::error("Validation errors", 403, $validation_errors);
    }

    // JSON response with lifetime of token
    static function respondWithToken($token, $type = "Bearer", $is_expire = true, $expires_in = 60)
    {
        $response = ["token" => $token, "type" => $type];

        if ($is_expire && $expires_in) {
            $response['expires_in'] = \Config::get('jwt.ttl') * $expires_in;
        }

        return response()->json($response, 200);
    }
}
