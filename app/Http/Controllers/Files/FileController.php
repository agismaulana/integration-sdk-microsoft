<?php

namespace App\Http\Controllers\Files;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    protected $token;
    public function __construct() {
        $this->token = $this->getToken();
    }

    public function getFiles(Request $request):JsonResponse
    {
        try {
            $graphClient = new GraphGatewayClient($this->token, '/me/drives');
            $drive = $graphClient->get()->getBody();
        } catch(Exception $e) {
            $code = $e->getCode() !== 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST;
            return $this->sendError([
                'message' => $e->getMessage(),
            ], $code);
        }

        return $this->sendSuccess($drive);
    }
}
