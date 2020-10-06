<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
use App\Models\PlanType;

class StepController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $insurance = \Lang::get('step.insurance');

        View::share('insurance', $insurance);
    }

    /**
     *
     * @param Request $request
     * @return view
     */
    public function step1(Request $request)
    {
        //$request->session()->forget('name');
        $step = 1;
        return view('step/step1', compact('step'));
    }

    /**
     *
     * @param Request $request
     * @return view
     */
    public function step2(Request $request)
    {
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            $data  = $request->validate([
                'name'      => "required|string|max:20",
                'plan_type' => "integer",
            ]);
            $request->session()->put('name', $data['name']);
        }
        $step = 2;
        return view('step/step2', compact('step'));
    }

    /**
     *
     * @param Request $request
     * @return view
     */
    public function step3(Request $request)
    {
        $step = 3;
        $disply_date = $request->session()->get('disply_date');
        if ($disply_date == null) {
            $request->session()->flash('flash_message', 'PDFを表示してください');
            return redirect()->back();
        }
        return view('step/step3', compact('step'));
    }

    /**
     *
     * @param Request $request
     * @return view
     */
    public function step4(Request $request)
    {
        $step = 4;
        return view('step/step4', compact('step'));
    }

    /**
     *
     * @param Request $request
     * @return view
     */
    public function step5(Request $request)
    {
        //$request->session()->flush();
        $request->session()->forget('name');
        $request->session()->forget('disply_date');
        $request->session()->forget('id');
        $request->session()->forget('plan_name');
        $request->session()->forget('plan_fee');
        $request->session()->forget('description');
        $step = 1;
        return view('step/step1', compact('step'));
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

    /**
     * POST：プランに応じた情報を取得
     *
     * @return array
     */
    public function store(Request $request)
    {
        $data = PlanType::where('id', $_POST['plan_id'])->get();

        foreach ($data as $session_data) {
            $request->session()->put('id', $session_data['id']);
            $request->session()->put('plan_fee', $session_data['plan_fee']);
            $request->session()->put('plan_name', $session_data['plan_name']);
            $request->session()->put('description', $session_data['description']);
        }
        //正常を返す
        return response()->success($data, self::RESPONSE_CODE_200);
    }
}
