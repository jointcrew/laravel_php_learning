<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PutRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiItemUserController extends Controller
{
    /**
     * GET：全てのデータを取得。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::all()->toArray();
        //正常を返す
        return response()->success($user, self::RESPONSE_CODE_200);
    }

    /**
     * GET：指定したデータを表示
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //$idがstringなので一度intに変換
        $int_id = (int)$id;
        //intにしたときに値が同じなら検索、違ったらエラー
        if ("$int_id" == $id) {
            $user = User::find($id)->toArray();
            $user_array = array();
            $user_array[0] = $user;
        } else {
            //エラーを返す
            return response()->error(\Lang::get('api.api_e_title.t0001'), array(\Lang::get('api.api_mes.m0001')), self::RESPONSE_CODE_400);
        }
        //正常を返す
        return response()->success($user_array, self::RESPONSE_CODE_200);
    }

    /**
     * POST：登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //
    }

    /**
     * PUT：変更
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PutRequest $request, $id)
    {
        //
    }

    /**
     * DELETE：削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
