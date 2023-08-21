<?php

namespace App\Http\Controllers;

use App\Gateway\GraphGatewayClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;

class ProfileController extends Controller
{
    public function me(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $graph = new Graph();
        $graph->setAccessToken($token);
        $user = $graph->createRequest("GET", "/me")
        ->execute();

        return response()->json($user->getBody());
    }

    public function calendar(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $graphClient = new GraphGatewayClient($token, '/me/calendars');
        $calendar = $graphClient->get()->getBody();
        return response()->json($calendar);
    }

    public function mail(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $graphClient = new GraphGatewayClient($token, '/me/messages');
        $mail = $graphClient->get()->getBody();
        return response()->json($mail);
    }

    public function sendMail(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $graphClient = new GraphGatewayClient($token, '/me/sendMail', [
            'message' => [
                'subject' => Carbon::parse(now())->format('d/m/Y'),
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $request->input('content'),
                ],
                'toRecipients' => [
                    [
                        'emailAddress' => [
                            'address' => $request->input('recipients')
                        ]
                    ]
                ],
                'internetMessageHeaders' => [
                    [
                        'name' => 'x-custom-header-group-name',
                        'value' => 'Nawatech'
                    ],
                    [
                        'name' => 'x-custom-header-group-id',
                        'value' => 'NW001'
                    ]
                ]
            ]
        ]);
        $graphClient->post();
        return response()->json([
            'message' => 'E-mail sent successfully',
            'error' => false
        ]);
    }
}
