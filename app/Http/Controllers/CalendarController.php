<?php

namespace App\Http\Controllers;

use App\Gateway\GraphGatewayClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Microsoft\Graph\Graph;

class CalendarController extends Controller
{
    public function index(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        /**
         *
         * message: under this code to get data calendar when error send message error
         *
        */
        try {
            $graphClient = new GraphGatewayClient($token, '/me/calendars');
            $calendar = $graphClient->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($calendar);
    }

    public function create(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $scopes = [
            "name" => $request->input('name'),
        ];

        /**
         *
         * message: under this code to create data calendar when error send message error
         *
        */
        try {
            $createCalendar = new GraphGatewayClient($token, '/me/calendars', $scopes);
            $createCalendar->post();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Data has been created',
            'error' => false
        ], Response::HTTP_CREATED);
    }

    public function show(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        /**
         *
         * message: under this code to get data calendar when error send message error
         *
        */
        try {
            $calendar = new GraphGatewayClient($token, '/me/calendars/'.$request->route('id'));
            $calendar = $calendar->get()->getBody();
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json($calendar);
    }

    public function update(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        /**
         *
         * message: under this code to check data calendar if exists when error send message error
         *
        */
        try {
            $calendar = new GraphGatewayClient($token, '/me/calendars/'.$request->route('id'));
            $calendar->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        /**
         *
         * message: under this code to send data calendar to take process update when error send message error
         *
        */

        $scopes = [
            'name' => $request->input('name')
        ];

        try {
            $updateCalendar = new GraphGatewayClient($token, '/me/calendars/'.$request->route('id'), $scopes);
            $updateCalendar->patch();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'error' => true,
            ], $e->getCode() != 0 ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Data has been updated',
            'error' => false
        ], Response::HTTP_CREATED);
    }

    public function delete(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);

        $calendar = new GraphGatewayClient($token, '/me/calendars/'.$request->route('id'));
        $calendar = $calendar->get()->getBody();
        if(empty($calendar))
            return response()->json([
                'message' => 'Data not found',
                'error' => false,
            ], Response::HTTP_NOT_FOUND);

        $graphClient = new GraphGatewayClient($token, '/me/calendars/'.$request->route('id'));
        if($graphClient->delete()) {
            return response()->json([
                'message' => 'Calendar has been Deleted',
                'error' => false
            ], Response::HTTP_ACCEPTED);
        }
        return response()->json([
            'message' => 'Something Error...!',
            'error' => false
        ], Response::HTTP_BAD_REQUEST);
    }
}
