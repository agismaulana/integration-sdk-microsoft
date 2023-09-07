<?php

namespace App\Common\Client;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

trait LoginMicrosoft {
    /**
     * Schema Login Microsoft by trait php
     * @param array $data
     *
     * */
    public static function sendLoginMicrosoft(
        array $data
    ): JsonResponse {
        $url = env('MICROSOFT_LOGIN_URL');
        $client_id = env('MICROSOFT_CLIENT_ID');
        $client_secret = env('MICROSOFT_CLIENT_SECRET');
        $scope = env('MICROSOFT_DEFAULT_SCOPE');
        $tenant = env("MICROSOFT_TENANT_ID");

        // $url = $url."common/oauth2/v2.0/token";
        $url = $url.$tenant."/oauth2/v2.0/token";
        $data = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'client_id' => $client_id,
                'scope' => $scope,
                'username' => $data['email'],
                'password' => $data['password'],
                'grant_type' => 'password',
            ],
        ];

        try {
            $client = new Client();
            $post = $client->post($url, $data);
            $body = json_decode($post->getBody()->getContents());
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ]);
        }

        return response()->json([
            'data' => $body,
            'message' => 'Data Berhasil Login',
            'error' => false,
        ]);
    }
}
