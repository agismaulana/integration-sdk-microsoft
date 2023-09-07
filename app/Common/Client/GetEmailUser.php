<?php

namespace App\Common\Client;

use App\Gateway\GraphGatewayClient;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait GetEmailUser {
    /**
     * Schema Get Data User on array
     *
     * */
    public static function getUserByEmail(
        string $token,
        string $email
    ):JsonResponse
    {
        try {
            $graphClient = new GraphGatewayClient($token, '/users/'.$email);
            $user = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], $code);
        }

        return response()->json([
            'data' => [
                'name' => $user->displayName,
                'email' => $user->email,
            ],
        ]);
    }
}
