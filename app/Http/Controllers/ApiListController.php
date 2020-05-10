<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * API一覧画面
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('apiList');
    }

}
