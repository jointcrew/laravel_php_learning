<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Types;
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

        $summary = User::search($data);

        if ($summary == false) {
            //エラーを返す
            return response()->error(\Lang::get('api.api_e_title.t0001'), array(\Lang::get('api.api_mes.m0001')), self::RESPONSE_CODE_400);
        }
        //正常を返す
        return response()->success($summary, self::RESPONSE_CODE_200);
    }

    /**
     * カテゴリに応じて種別をDBから取得する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $html = '';
        $flag = $_POST['flag'];
        //
        if ($flag == 'type_value') {
            $type_vale = $_POST['type_value'];
            $categorys_id = Types::categoryIdSearch($type_vale);
            foreach ($categorys_id as $category) {
                $category_id = $category["category_id"];
            }
        } elseif ($flag == 'category_id') {
            $category_id = $_POST['category'];
        }

        $types = Types::search($category_id);

        foreach ($types as $type) {
            if (!isset($type_vale)) {
                $html .= '<option id="type" name="type" value="' . $type['value_number'] . '">' . $type['type_name'] . '</option>';
            }
            if ((isset($type_vale)) && ($type['value_number'] == $type_vale)) {
                $html .= '<option selected id="type" name="type" value="' . $type['value_number'] . '">' . $type['type_name'] . '</option>';
            } elseif (isset($type_vale)) {
                $html .= '<option id="type" name="type" value="' . $type['value_number'] . '">' . $type['type_name'] . '</option>';
            }
        }
        if ($types == false) {
            //エラーを返す
            return response()->error(\Lang::get('api.api_e_title.t0001'), array(\Lang::get('api.api_mes.m0001')), self::RESPONSE_CODE_400);
        }
        //正常を返す
        return response()->success($html, self::RESPONSE_CODE_200);
    }
}
