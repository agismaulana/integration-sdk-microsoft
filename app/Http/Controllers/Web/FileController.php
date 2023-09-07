<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileController extends Controller
{
    public function index(Request $request):View {
        return view('files.index');
    }

    public function create(Request $request):View {
        return view('files.create');
    }
}
