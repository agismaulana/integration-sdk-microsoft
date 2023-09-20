<?php

namespace App\Http\Controllers\Users;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalendarController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = $this->getMicrosoftToken();
    }

    public function index() {
        $token = $this->token;
        $user = auth()->user();
        $user_microsoft = $user->MicrosoftAccount;

        try {
            $graphClient = new GraphGatewayClient($token, '/users/'.$user_microsoft->microsoft_id.'/calendars');
            $calendar = $graphClient->get()->getBody();
        } catch (Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess($calendar);
    }
}
