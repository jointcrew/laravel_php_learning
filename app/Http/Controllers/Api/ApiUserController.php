<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiUser;

class ApiUserController extends Controller
{
    /**
     * GET：全てのデータを取得。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = ApiUser::all()->toArray();
        //正常を返す
        return response()->success($user, self::RESPONSE_CODE_200);
    }

    /**
     * GET：指定したデータを表示
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$idがstringなので一度intに変換
        $int_id = (int)$id;

        //intにしたときに値が同じなら検索、違ったらエラー
        if ("$int_id" == $id) {
            $user = ApiUser::find($id);
        } else {
            //エラーを返す
            // return response()->error($validator->errors()->all());
            return response()->error(\Lang::get('api.api_e_title.t0001'), array(\Lang::get('api.api_mes.m0001')), self::RESPONSE_CODE_400);
        }
        //正常を返す
        return response()->success($user, self::RESPONSE_CODE_200);
    }

    /**
     * POST：登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'store';
    }

    /**
     * PUT：変更
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 'update';
    }

    /**
     * DELETE：削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return 'destroy';
    }
}
