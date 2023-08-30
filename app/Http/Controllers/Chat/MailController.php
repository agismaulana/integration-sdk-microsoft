<?php

namespace App\Http\Controllers\Chat;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MailController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = $this->getToken();
    }

    public function index(Request $request) {
        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/messages');
            $mail = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ]);
        }

        return $this->sendSuccess($mail);
    }

    public function show(Request $request) {
        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/messages/'.$request->route('mailId'));
            $mail = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ]);
        }

        return $this->sendSuccess($mail);
    }

    public function sendMail(Request $request) {
        $scopes = $request->all();

        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/sendMail', $scopes);
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'message' => "Send mail successfully"
        ]);
    }
}
