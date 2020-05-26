<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * 検索画面
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        return view('goodsSearch');
    }

    /**
     * 商品詳細
     * @param Request $request
     * @return view
     */
    public function goodsDetail(Request $request)
    {
        return view('goodsDetail');
    }

    /**
     * 決済画面
     * @param Request $request
     * @return view
     */
    public function goodsSettle(Request $request)
    {
        return view('goodsSettle');
    }

    /**
     * 商品登録・編集
     * @param Request $request
     * @return view
     */
    public function goodsEdit(Request $request)
    {
        return goodsEdit('goodsSearch');
    }

    /**
     * ユーザー管理
     * @param Request $request
     * @return view
     */
    public function goodsUser(Request $request)
    {
        return view('goodsUser');
    }

    /**
     * ユーザー編集
     * @param Request $request
     * @return view
     */
    public function goodsUserEdit(Request $request)
    {
        return view('goodsUserEdit');
    }
  }
