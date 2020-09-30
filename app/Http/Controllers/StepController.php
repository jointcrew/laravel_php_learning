<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StepController extends Controller
{
    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step1(Request $request)
    {
        return view('step/step1');
    }
}
