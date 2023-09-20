<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    /**
     * This function to be get token with request header
     * @return string
     *
    */
    public function getToken() {
        $request = request();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        return $token;
    }

    public function getMicrosoftToken() {
        return session()->get('microsoft_access_token');
    }

    /**
     * This function to be set response with status success
     * @param array|object $data
     * @param string $code
     *
     * @return JSONResponse
     * */
    public function sendSuccess($data = [], $code = Response::HTTP_OK): JsonResponse {
        if(gettype($data) === "object") {
            $data = (array)$data;
        }
        $data['error'] = false;
        return response()->json($data, $code);
    }

    /**
     * This function to be set response with status error
     * @param array $data
     * @param string $code
     *
     * @return json
     * */
    public function sendError($data = [], $code = Response::HTTP_BAD_REQUEST) {
        $data['error'] = true;
        return response()->json($data, $code);
    }
}
