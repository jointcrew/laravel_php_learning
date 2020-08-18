<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiUser;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiGoodsUserController extends Controller
{
    /**
     * GET：指定したデータを表示
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //配列に入力値を追加
        $data = [
            'category'          => $request->input('category'),
            'goods_name'        => $request->input('goods_name'),
            'price_start'       => $request->input('price_start'),
            'price_end'         => $request->input('price_end'),
            'date_start'        => $request->input('date_start'),
            'date_end'          => $request->input('date_end'),
            'user_id'           => $request->input('user_id'),
        ];

        $summary = Purchase::search($data);

        if ($summary == false) {
            //エラーを返す
            return response()->error(\Lang::get('api.api_e_title.t0001'), array(\Lang::get('api.api_mes.m0001')), self::RESPONSE_CODE_400);
        }
        //正常を返す
        return response()->success($summary, self::RESPONSE_CODE_200);
    }

    /**
     * POST：登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //配列に入力値を追加
        $data = [
            'user_name'        => $request->input('user_name'),
            'age'              => $request->input('age'),
            'create_user_id'   => $request->input('create_user_id'),
            'create_user_name' => $request->input('create_user_name'),
        ];
        //ApiUserモデルのinsertメソッドにアクセスし、データを保存
        $insert_data = ApiUser::insert($data);

        return response()->success($insert_data, self::RESPONSE_CODE_200);
    }
}
