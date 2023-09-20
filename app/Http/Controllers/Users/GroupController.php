<?php

namespace App\Http\Controllers\Users;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = $this->getMicrosoftToken();
    }

    public function index() {
        $group = [];
        try {
            $graphClient = new GraphGatewayClient($this->token, '/groups');
            $group = $graphClient->get()->getBody();
        } catch (Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $group,
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $scopes = [
            'description'       => $request->input('description'),
            'displayName'       => $request->input('display_name'),
            'groupTypes'        => explode(',', $request->input('group_types')),
            'mailNickName'      => $request->input('mail_nickname'),
            'mailEnabled'      => $request->input('mail_enabled') == 'on' ? true : false,
            'securityEnabled'   => $request->input('security_enabled') == 'on' ? true : false,
        ];

        try {
            $graphClient = new GraphGatewayClient($this->token, '/groups', $scopes);
            $post = $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'data' => "Group created Successfully"
        ]);
    }

    public function detail(Request $request): JsonResponse
    {
        try {
            $graphClient = new GraphGatewayClient($this->token, '/groups/'.$request->route('groupId'));
            $group = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }
        return $this->sendSuccess([
            'data' => $group,
        ]);
    }

    public function listMember(Request $request): JsonResponse
    {
        $groupList = [];
        try {
            $graphClient = new GraphGatewayClient($this->token, '/groups/'.$request->route('groupId').'/members');
            $groupList = $graphClient->get()->getBody();
        } catch (Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage()
            ], $code);
        }

        return $this->sendSuccess([
            'data' => $groupList,
        ]);
    }

    public function addMember(Request $request) {
        $scope = [
            '@odata.id' => 'https://graph.microsoft.com/v1.0/directoryObjects/'.$request->input('member'),
        ];

        try {
            $graphClient = new GraphGatewayClient($this->token, '/groups/'.$request->route('groupId').'/members/$ref', $scope);
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST ;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'message' => 'Member joined successfully'
        ], Response::HTTP_CREATED);
    }
}
