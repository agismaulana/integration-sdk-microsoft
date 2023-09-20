<?php

namespace App\Http\Controllers\Users;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use App\Http\Resources\Users\PeopleResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeopleController extends Controller
{
    public function index(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $graphClient = new GraphGatewayClient($token, '/users');
            $people = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'context' => $people['@odata.context'],
            'data' => PeopleResource::collection($people['value']),
        ]);
    }

    public function show(Request $request) {
        $token = $this->getMicrosoftToken();

        try {
            $graphClient = new GraphGatewayClient($token, '/users/'.$request->route('userId'));
            $people = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json(PeopleResource::make($people));
    }

    public function update(Request $request) {
        $token = $this->getMicrosoftToken();

        $scopes = $request->all();

        try {
            $graphClient = new GraphGatewayClient($token, '/users/'.$request->route('userId'), $scopes);
            $people = $graphClient->patch();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return $this->sendSuccess([
            'message' => "Users Update Successfully"
        ], Response::HTTP_CREATED);
    }
}
