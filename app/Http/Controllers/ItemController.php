<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * サンプルトップ画面
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーのID取得
        $id = Auth::id();
        $me = 'まだ登録してない';
        //Sampleモデルに記載している、種別を取得
        $type_array = Item::$type;

        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            //フォームの内容をすべて取得(一部取りたいときは$request->sample_name()のようにフィールド名を指定)
            $data = $request->all();
            //配列にcreate_userを追加
            $data['create_user'] = $id;
            //Sampleモデル\のinsertメソッドにアクセスし、データを保存
            $aaa = Item::insert($data);
            if ($aaa == true) {
              $me = '登録したよ';
            } else {
              $me = '登録失敗したよ';
            }

        }

        return view('items', compact('type_array','me'));
    }

    /**
     * サンプル一覧画面
     * @param Request $request
     * @return view
     */
    public function itemList(Request $request)
    {
        $list = Item::all();

        return view('itemList', compact('list'));
    }
}
