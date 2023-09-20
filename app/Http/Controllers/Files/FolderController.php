<?php

namespace App\Http\Controllers\Files;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FolderController extends Controller
{
    protected $token;
    public function __construct()
    {
        $this->token = $this->getMicrosoftToken();
    }

    public function create(Request $request) {
        $scopes = [
            'name' => $request->input('name'),
            'folder' => [],
            '@microsoft.graph.conflictBehavior' => 'rename',
        ];

        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/drive/items/root/children', $scopes);
            $graphClient->post();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess([
            'message' => 'Folder Created Successfully',
        ], Response::HTTP_CREATED);
    }
}
