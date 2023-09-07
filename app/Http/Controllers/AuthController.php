<?php

namespace App\Http\Controllers;

use App\Common\Client\LoginMicrosoft;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as Controller;

class AuthController extends Controller
{
    use LoginMicrosoft;

    public function login(Request $request) {
        return view('auth.login');
    }

    public function auth(Request $request) {
        $data = $request->only(['email', 'password']);
        $send = $this->sendLoginMicrosoft($data)->getData();
        return $this->sendSuccess($send);
    }

    public function register(Request $request) {
        $data = [
            ''
        ];

        $this->sendLoginMicrosoft($data);
    }
}
