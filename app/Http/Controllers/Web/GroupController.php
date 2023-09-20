<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index() {
        return view('group.index');
    }

    public function create(Request $request) {
        return view('group.create');
    }

    public function add(Request $request) {
        return view('group.add-member')->with([
            'id' => $request->route('groupId'),
        ]);
    }

    public function edit(Request $request) {
        return view('group.edit');
    }

    public function detail(Request $request) {
        return view('group.detail')->with(['id' => $request->route('groupId')]);
    }
}
