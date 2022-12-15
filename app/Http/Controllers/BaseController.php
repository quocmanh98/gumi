<?php

namespace App\Http\Controllers;


class BaseController extends Controller
{
    /**
     * Summary of sendSuccess
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccess($data)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'status' => 200
        ];

        return response()->json($response, 200);
    }

    /**
     * Summary of sendError
     * @param mixed $data
     * @param mixed $message
     * @param mixed $code
     * @return \Illuminate\Http\JsonResponse
     */
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
