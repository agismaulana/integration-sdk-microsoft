<?php

namespace App\Http\Controllers\Web;

use App\Gateway\GraphGatewayClient;
use App\Http\Controllers\BaseController as Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MailController extends Controller
{
    public function index(Request $request): View
    {
        return view('email.index');
    }

    public function create(Request $request): View
    {
        return view('email.create');
    }

    public function show(Request $request): View {
        return view('email.show')->with([
            'id' => $request->route('id')
        ]);
    }

    public function forward(Request $request): View {
        return view('email.forward')->with([
            'id' => $request->route('id')
        ]);
    }
}
