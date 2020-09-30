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
        $step = 1;
        return view('step/step1', compact('step'));
    }

    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step2(Request $request)
    {
        $step = 2;
        return view('step/step2', compact('step'));
    }

    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step3(Request $request)
    {
        $step = 3;
        return view('step/step3', compact('step'));
    }

    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step4(Request $request)
    {
        $step = 4;
        return view('step/step4', compact('step'));
    }
}
