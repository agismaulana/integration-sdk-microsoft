<?php

namespace App\Common\Client;

use App\Gateway\GraphGatewayClient;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

trait LoginMicrosoft {
    /**
     * Schema Login Microsoft by trait php
     * @param array $data
     *
     * */
    public static function sendLoginMicrosoft(): JsonResponse
    {
        $url = env('MICROSOFT_LOGIN_URL');
        $client_id = env('MICROSOFT_CLIENT_ID');
        $client_secret = env('MICROSOFT_CLIENT_SECRET');
        $scope = env('MICROSOFT_DEFAULT_SCOPE');
        $tenant = env("MICROSOFT_TENANT_ID");

        $url = $url.$tenant."/oauth2/v2.0/token";
        $data = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'client_id' => $client_id,
                'scope' => $scope,
                'client_secret' => $client_secret,
                'grant_type' => 'client_credentials'
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

        Session::put('microsoft_access_token', $body->access_token);
        Session::save();

        return response()->json([
            'body' => $body,
            'message' => 'Application Microsoft berhasil login',
            'error' => false,
        ]);
    }

    public static function registerMicrosoft(
        array $data
    ): JsonResponse
    {
        try {
            $client = new GraphGatewayClient(session()->get('microsoft_access_token'), '/users', $data);
            $post = $client->post();
            $content = $post->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ]);
        }

        return response()->json([
            'data' => $content,
            'message' => 'Data Berhasil Register',
            'error' => false,
        ]);
    }
}
