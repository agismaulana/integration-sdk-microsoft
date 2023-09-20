<?php

namespace App\Http\Controllers\Web;

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
        return view('users.my');
    }
}
