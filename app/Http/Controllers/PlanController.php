<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PlanType;

class PlanController extends Controller
{
    /**
     *
     * @param Request $request
     * @return view
     */
    public function plan(Request $request)
    {
        $datalist = PlanType::all();
        return view('step/plan', compact('datalist'));
    }

    /**
     * POST：プランに応じた情報を取得
     *
     * @return array
     */
    public function store(Request $request)
    {
        $insert_data['plan_name']    = $_POST['plan_name'];
        $insert_data['plan_fee']     = $_POST['plan_fee'];
        $insert_data['description']  = $_POST['description'];
        $insert_data['id'] = PlanType::insertGetId($insert_data);

        //正常を返す
        return response()->success($insert_data, self::RESPONSE_CODE_200);
    }

    /**
     * DELETE：削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //配列に入力値を追加
        $id = $_POST['id'];
        $user = PlanType::find($id);
        //プランが見つからないとき
        if ($user == null) {
            return response()->error(\Lang::get('api.api_e_title.t0003'), array(\Lang::get('api.api_mes.m0003')), self::RESPONSE_CODE_400);
        }
        //ApiUserモデルのApiUserメソッドにアクセスし、データを編集
        $delete = PlanType::where('id', $id)->delete();

        return response()->success($user, self::RESPONSE_CODE_200);
    }
}
