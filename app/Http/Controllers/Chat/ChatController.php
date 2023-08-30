<?php

namespace App\Http\Controllers\Chat;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
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

    public function updateSendMessage(Request $request) {
        $token = $this->getToken();

        $scopes = [
            'body' => [
                'content' => $request->input('content')
            ]
        ];

        try {
            $graphClient = new GraphGatewayClient($token, '/chats/'.$request->route('chatId').'/messages/'.$request->route('messageId'), $scopes);
            $graphClient->patch();
        } catch(Exception $e) {
            $code = $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess(['message' => 'Update Chat Successfully'], Response::HTTP_CREATED);
    }

    public function deleteMessage(Request $request) {
        $token = $this->getToken();

        try {
            $graphClient = new GraphGatewayClient($token, '/users/'.$request->route('userId').'/chats/'.$request->route('chatId').'/messages/'.$request->route('messageId').'/softDelete');
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess(['message' => 'Update Chat Successfully'], Response::HTTP_CREATED);
    }

    public function undoDeleteMessage(Request $request) {

    }
}
