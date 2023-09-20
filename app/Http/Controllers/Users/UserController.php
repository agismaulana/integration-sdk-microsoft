<?php

namespace App\Http\Controllers\Users;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = $this->getMicrosoftToken();
    }

    public function my(Request $request) {
        $user = auth()->user();
        $microsoft_account = $user->MicrosoftAccount;
        try {
            $graphClient = new GraphGatewayClient($this->token, '/users/'.$microsoft_account->microsoft_id);
            $user_microsoft = $graphClient->get()->getBody();
            dd($user_microsoft);
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        $user->microsoft = $user_microsoft;

        return $this->sendSuccess([
            'token' => $this->token,
            'data' => $user,
            'message' => 'User Successfully',
        ]);
    }

    public function license(Request $request) {
        $user = auth()->user();
        $microsoft_account = $user->MicrosoftAccount;
        try {
            $graphClient = new GraphGatewayClient($this->token, '/users/'.$microsoft_account->microsoft_id.'/licenseDetails');
            $license = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $license
        ]);
    }

    public function organization() {
        $user = auth()->user();
        try {
            $graphClient = new GraphGatewayClient($this->token, '/organization');
            $organize = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $organize
        ]);
    }

    public function mailboxSettings() {
        $user = auth()->user();
        $microsoft_user = $user->MicrosoftAccount;
        try {
            $graphClient = new GraphGatewayClient($this->token, '/users/'.$microsoft_user->microsoft_id.'/mailboxSettings');
            $mailbox = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $mailbox
        ]);
    }
}
