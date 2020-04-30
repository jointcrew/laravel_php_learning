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
            $data = $request->validate([
              //バリデーション追加
              'item_name'      =>'required|max:20',
              'apply'          =>'required',
              'selector'       =>'required',
              'price'          =>'required|integer|max:20',
              'item_name_kana' =>'required|max:20|regex:/^[ァ-ヶ]+$/u',
            ]);
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

        return view('items', compact('type_array','me','request'));
    }

    /**
     * サンプル一覧画面
     * @param Request $request
     * @return view
     */
    public function itemList(Request $request)
    {
        $limit=5;
      //itemモデルから全件データを取得する。
        $list = Item::paginate($limit);

        return view('itemList', compact('list'));
    }



    /**
     * アイテム検索画面
     * @param Request $request
     * @return view
     */

    public function itemsearch(Request $request)
    {
      // 現在認証されているユーザーの取得
          $user = Auth::user();
      // 現在認証されているユーザーのID取得
          $id = Auth::id();
          //フォームの内容をすべて取得(一部取りたいときは$request->sample_name()のようにフィールド名を指定)
          $data = $request->validate([
            //バリデーション追加
            'item_name' =>'max:20',
            
          ]);
          //配列に入力値を追加
          $data['create_user'] = $id;
          $data['item_name'] = $request->input('item_name');
          $data['apply'] = $request->input('apply');
          $data['selector'] = $request->input('selector');
          $data['price'] = $request->input('price');
          $data['date_start'] = $request->input('date_start');
          $data['date_end'] = $request->input('date_end');
          //itemモデルのsearchメソッドにアクセスし、データを取得
          $searchlist = Item::search($data);

        return view('itemsearch', compact('searchlist','request', 'data'));
    }

    /**
     * 商品消去
     * @param Request $request
     * @return view
     */
     public function itemDelete(Request $request)
     {
         // 現在認証されているユーザーの取得
         $user = Auth::user();
         // 現在認証されているユーザーのID取得
         $id = Auth::id();
         //フォームの内容をすべて取得
         $data = $request->all();
         //itemモデルのdeleteメソッドにアクセスし、データを削除
         $delete = Item::itemDelete($data);
         if ($delete === 0) {
            $msg= '削除失敗';
         } else {
            $msg = '削除しました';
         }
         //配列挿入
         $data['create_user'] = $id;
         $data['item_name'] = $request->input('item_name');
         $data['apply'] = $request->input('apply');
         $data['selector'] = $request->input('selector');
         $data['price'] = $request->input('price');
         $data['date_start'] = $request->input('date_start');
         $data['date_end'] = $request->input('date_end');
         //itemモデルのsearchメソッドにアクセスし、データを取得
         $searchlist = Item::search($data);

         return view('itemsearch', compact('msg','request','searchlist','data'));
    }


    /**
     * 商品編集画面
     * @param Request $request
     * @return view
     */
     public function itemEdit(Request $request)
     {
       // 現在認証されているユーザーの取得
       $user = Auth::user();
       // 現在認証されているユーザーのID取得
       $id = Auth::id();
       //フォームの内容をすべて取得
       $item_id = $request->input('itemId');
       //var_dump($data);
       //exit;
       $data = Item::find($item_id);
       //var_dump($data);
       //exit;
       //保存ボタンを押したときに処理をする
       if ($request->isMethod('post') == true) {
           //フォームの内容をすべて取得
           $data = $request->all();
           //配列にcreate_userを追加
           $data['item_id'] =$request->input('item_id');
           $data['create_user'] = $id;
           $data['item_name'] = $request->input('item_name');
           $data['apply'] = $request->input('apply');
           $data['selector'] = $request->input('selector');
           $data['price'] = $request->input('price');
           //Sampleモデル\のitemEditメソッドにアクセスし、データを編集
           $searchlist = Item::itemEdit($data);
           return redirect()->route('itemsearch');
      }

     return view('itemEdit',compact('request','data','item_id'));
    }

  }
