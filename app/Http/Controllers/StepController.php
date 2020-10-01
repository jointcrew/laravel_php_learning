<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class StepController extends Controller
{
    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step1(Request $request)
    {
        //$request->session()->forget('name');
        $name = $request->session()->get('name');
        $step = 1;
        return view('step/step1', compact('step', 'name'));
    }

    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function step2(Request $request)
    {
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            $name  = $request->validate([
                'name' => "required|string|max:20"
            ]);
            $request->session()->put('name', $name);
        }
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
        $name = $request->session()->get('name');
        $disply_date = $request->session()->get('disply_date');
        return view('step/step4', compact('step', 'name', 'disply_date'));
    }

    /**
     * GET：PDF表示時間をsessionに保存
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $disply_date = date("Y-m-d H:i:s");
        $request->session()->put('disply_date', $disply_date);
        return $disply_date;
    }
}
