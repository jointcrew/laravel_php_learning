<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PutRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\ApiUser;
use Illuminate\Support\Facades\Auth;

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
        $user = ApiUser::find($id);
        //$idがstringなので一度intに変換
        $int_id = (int)$id;
        //intにしたときに値が同じなら検索、違ったらエラー
        if ("$int_id" == $id) {
            $user = ApiUser::find($id);
        } else {
            //エラーを返す
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

    /**
     * PUT：変更
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PutRequest $request, $id)
    {
        //配列に入力値を追加
        $data = [
            'id'        => $id,
            'user_name' => $request->input('user_name'),
            'age'       => $request->input('age'),
        ];
        $user = ApiUser::find($id);
        //ユーザーが見つからないとき
        if ($user == null) {
            return response()->error(\Lang::get('api.api_e_title.t0003'), array(\Lang::get('api.api_mes.m0003')), self::RESPONSE_CODE_400);
        }
        //ApiUserモデルのApiUserメソッドにアクセスし、データを編集
        $searchlist = ApiUser::apiUserEdit($data);
        //更新したデータを取得しなおして返す
        $update_data = ApiUser::find($data['id']);

        return response()->success($update_data, self::RESPONSE_CODE_200);
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
        $data['id'] = $id;
        $user = ApiUser::find($data['id']);
        //ユーザーが見つからないとき
        if ($user == null) {
            return response()->error(\Lang::get('api.api_e_title.t0003'), array(\Lang::get('api.api_mes.m0003')), self::RESPONSE_CODE_400);
        }
        //ApiUserモデルのApiUserメソッドにアクセスし、データを編集
        $delete = ApiUser::apiUserDelete($data);

        return response()->delete_success(self::RESPONSE_CODE_200);
    }
}
