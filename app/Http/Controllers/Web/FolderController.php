<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    public function index(Request $request) {
        return view('folder.index');
    }

    public function create(Request $request):View {
        return view('folder.create');
    }
}
