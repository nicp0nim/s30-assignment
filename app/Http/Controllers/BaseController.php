<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Method to serve success responses
     * 
     */
    public function sendResponse($message, $data, $code = 200) {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    /**
     * Method to serve error responses
     * 
     */
    public function sendError($message, $validation = [], $code = 404) {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($validation)) {
            $response['errors'] = $validation;
        }

        return response()->json($response, $code);
    }
}
