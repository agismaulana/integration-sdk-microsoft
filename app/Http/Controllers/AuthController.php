<?php

namespace App\Http\Controllers;

use App\Common\Client\LoginMicrosoft;
use App\Gateway\GraphGatewayClient;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as Controller;
use App\Models\MicrosoftAccount;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthController extends Controller
{
    use LoginMicrosoft;

    public function login(Request $request) {
        return view('auth.login');
    }

    public function auth(Request $request) {
        $data = $request->only(['email', 'password']);
        if(!$token = auth('api')->attempt($data)) {
            return $this->sendError([
                'message' => 'wrong username or password'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $send = $this->sendLoginMicrosoft()->getData();
        return $this->sendSuccess([
            'data' => [
                'access_token' => $token,
                'expiresIn' => 3600,
            ]
        ]);
    }

    public function register(Request $request):View
    {
        return view('auth.register');
    }

    public function sendRegister(Request $request): RedirectResponse
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $dataUser = [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->input('password')),
            'remember_token' => '',
        ];

        DB::transaction(function() use($dataUser, $name) {
            $user = new User();
            $user->fill($dataUser);
            $user->save();

            $mail = strtolower(str_replace(" ", "", $name));

            $data = [
                'accountEnabled' => true,
                'displayName' => $name,
                'mailNickname' => $mail,
                'userPrincipalName' => $mail.'@'.env('MICROSOFT_DOMAIN_EMAIL'),
                'passwordProfile' => [
                    'forceChangePasswordNextSignIn' => true,
                    'password' => bcrypt('password'),
                ]
            ];

            try {
                $this->sendLoginMicrosoft();
                $register = $this->registerMicrosoft($data)->getData();
            } catch(Exception $e) {
                $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
                return $this->sendError([
                    'message' => $e->getMessage(),
                ], $code);
            }

            $microsoft = new MicrosoftAccount();
            $microsoft->fill([
                'user_id' => $user->id,
                'microsoft_id' => $register->data->id,
                'microsoft_email' => $register->data->userPrincipalName
            ]);
            $microsoft->save();
        });

        return to_route('web.auth.login');
    }

    public function setMicrosoftToken(Request $request): JsonResponse
    {
        $token = [];
        try {
            $token = $this->sendLoginMicrosoft()->getData();
        } catch (Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $token,
        ]);
    }
}
