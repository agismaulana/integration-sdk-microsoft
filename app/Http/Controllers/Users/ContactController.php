<?php

namespace App\Http\Controllers\Users;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    public function index(Request $request) {
        $token = $this->getToken();

        try {
            $graphClient = new GraphGatewayClient($token, '/me/contacts');
            $contact = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess($contact);
    }

    public function show(Request $request) {
        $token = $this->getToken();

        try {
            $graphClient = new GraphGatewayClient($token, 'me/contacts/'.$request->route('contactId'));
            $contact = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess($contact);
    }
}
