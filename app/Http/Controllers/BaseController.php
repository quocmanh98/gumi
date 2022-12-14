<?php

namespace App\Http\Controllers;


class BaseController extends Controller
{
    public function sendSuccess($data)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'status' => 200
        ];

        return response()->json($response, 200);
    }

    public function sendError($data = null, $message, $code = 404)
    {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ];

        return response()->json($response, $code);
    }
}
