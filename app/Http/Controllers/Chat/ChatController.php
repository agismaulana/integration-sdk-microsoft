<?php

namespace App\Http\Controllers\Chat;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            // $graphClient = new GraphGatewayClient($token, '/users/'.$userId.'/chats');
            $graphClient = new GraphGatewayClient($token, '/me/chats');
            $drive = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($drive);
    }

    public function show(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/me/chats/'.$request->route('chatId'));
            $chat = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($chat);
    }

    public function allMessages(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/me/chats/'.$request->route('chatId').'/messages');
            $chat = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($chat);
    }

    public function sendMessages(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $scopes = [
            'body' => [
                'content' => $request->input('content')
            ]
        ];

        try {
            $graphClient = new GraphGatewayClient($token, '/me/chats/'.$request->route('chatId').'/messages', $scopes);
            $graphClient->post();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'You Send Message Successfully',
            'error' => false,
        ], Response::HTTP_CREATED);
    }
}
