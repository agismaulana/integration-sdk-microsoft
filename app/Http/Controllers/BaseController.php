<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

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

    /**
     * This function to be set response with status success
     * @param array $data
     * @param string $code
     *
     * @return json
     * */
    public function sendSuccess($data = [], $code = Response::HTTP_OK) {
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
