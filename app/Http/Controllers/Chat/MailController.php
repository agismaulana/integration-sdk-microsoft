<?php

namespace App\Http\Controllers\Chat;

use App\Common\Client\GetEmailUser;
use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function PHPSTORM_META\map;

class MailController extends Controller
{
    use GetEmailUser;
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
            ], $code);
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
        $scope = $request->all();

        // explode recipient
        $recipient = explode(',', $scope['toRecipient']);
        $ccRecipient = explode(',', $scope['ccRecipient']);
        $toRecipient = $this->mapRecipients($recipient);
        $ccRecipient = $this->mapRecipients($ccRecipient);

        $scopes = [
            'message' => [
                'subject' => $scope['subject'],
                'body' => [
                    'content' => $scope['content'],
                    'contentType' => 'html',
                ],
                'toRecipients' => $toRecipient,
                'ccRecipients' => $ccRecipient
            ]
        ];

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

    public function mapRecipients($recipient) {
        return array_map(function($value) {
            return [
                'emailAddress' => [
                    'address' => $value
                ],
            ];
        }, $recipient);
    }

    public function forward(Request $request) {
        // $toRecipients = array_map(function($val) {
        //     return $this->getUserByEmail($this->token, $val);
        // }, $request->only('toRecipient'));
        $recipient = explode(',', $request->input('toRecipient'));
        $recipient = array_map(function($val) {
            return [
                'emailAddress' => [
                    'name' => '',
                    'address' => $val
                ]
            ];
        }, $recipient);

        $scopes = [
            'comment' => $request->input('comment'),
            'toRecipients' => $recipient
        ];

        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/messages/'.$request->route('mailId').'/forward', $scopes);
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== '0' ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }
    }

    public function listAttachment(Request $request) {

    }

    public function addAttachment(Request $request) {
        $scopes = [];


        try {
            $graphClient = new GraphGatewayClient('/me/messages/'.$request->route('mailId').'/attachments', $scopes);
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'message' => 'Successfully add attachment mail'
        ], Response::HTTP_CREATED);
    }
}
