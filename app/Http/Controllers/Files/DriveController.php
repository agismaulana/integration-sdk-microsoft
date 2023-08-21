<?php

namespace App\Http\Controllers\Files;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriveController extends Controller
{
    public function index(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/me/drives');
            $drive = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($drive);
    }

    public function show(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/drives/'.$request->route('id'));
            $drive = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($drive);
    }

    public function itemsByCurrentRootFolder(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/me/drive/root/children');
            $drive = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($drive);
    }
}
