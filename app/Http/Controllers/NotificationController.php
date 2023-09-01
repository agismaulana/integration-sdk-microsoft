<?php

namespace App\Http\Controllers;

use App\Gateway\GraphGatewayClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function listSubscriptions(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/subscriptions');
            $notification = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($notification);
    }

    public function createSubscriptions(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $scopes = [
                'changeType' => 'created',
                // 'notificationUrl' => env('APP_URL')."/api/v1/subscriptions/success",
                'notificationUrl' => "https://ms.devryuzcons.com/api/v1/webhook/subscriptions/success",
                'resource' => $request->input('resource'),
                // 'expirationDateTime' => date(now()->addDays(1)),
                'expirationDateTime' => now()->addDays(1),
                'clientState' => env('MICROSOFT_CLIENT_SECRET'),
                // 'clientState' => 'Client-secret-state',
                'latestSupportedTlsVersion' => 'v1_2'
            ];

            $graphClient = new GraphGatewayClient($token, '/subscriptions', $scopes);
            // dd($graphClient->post());
            $graphClient->post();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Subcription successfully created',
            'error' => false
        ]);
    }
}
