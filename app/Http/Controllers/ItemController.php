<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\katakana;
use Illuminate\Support\Facades\DB;

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
     * 商品追加画面
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
        //Itemモデルに記載している、種別を取得
        $type_array = Item::$type;

        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            //フォームの内容をすべて取得
            $data = $request->validate([
              //バリデーション追加
              'item_name'      =>'required|max:20',
              'item_name_kana' =>['required','max:20', new katakana],
              'apply'          =>'required',
              'selector'       =>'required',
              'price'          =>'required|digits_between:1,20',
            ]);
            //配列にcreate_userを追加
            $data['create_user'] = $id;
            //Itemモデルのinsertメソッドにアクセスし、データを保存
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
     * 商品一覧画面
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
          //フォームの内容をすべて取得
          $data = $request->validate([
            //バリデーション追加
            'item_name' =>'max:20',
            'item_name_kana' =>['max:20', new katakana]
          ]);
          //配列に入力値を追加
          $data['create_user'] = $id;
          $data['item_name'] = $request->input('item_name');
          $data['item_name_kana'] = $request->input('item_name_kana');
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
     * 商品削除
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
         $data['item_name_kana'] = $request->input('item_name_kana');
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
       //$item_idと同じ値があるレコードを取得
       $data = Item::find($item_id);
       //保存ボタンを押したときに処理をする
       if ($request->isMethod('post') == true) {
           //フォームの内容をすべて取得
           $data = $request->all();
           //配列にcreate_userを追加
           $data['item_id'] =$request->input('item_id');
           $data['create_user'] = $id;
           $data['item_name'] = $request->input('item_name');
           $data['item_name_kana'] = $request->input('item_name_kana');
           $data['apply'] = $request->input('apply');
           $data['selector'] = $request->input('selector');
           $data['price'] = $request->input('price');
           //ItemモデルのitemEditメソッドにアクセスし、データを編集
           $searchlist = Item::itemEdit($data);
           //商品検索へリダイレクト
           return redirect()->route('itemsearch');
      }

     return view('itemEdit',compact('request','data','item_id'));
    }

    /**
     * ユーザー一覧画面
     * @param Request $request
     * @return view
     */
    public function userList(Request $request)
    {
      // 現在認証されているユーザーの取得
      $user = Auth::user();
      // 現在認証されているユーザーのID取得
      $id = Auth::id();
      //var_dump($id);
      //exit;
      //Userモデルから全件データを取得する。
      $list = User::all();
      //var_dump($list);
      //exit;
        return view('userList',compact('list','id'));
    }

    /**
     * ユーザー編集画面
     * @param Request $request
     * @return view
     */
     public function userEdit(Request $request)
     {
       // 現在認証されているユーザーの取得
       $user = Auth::user();
       // 現在認証されているユーザーのID取得
       $id = Auth::id();
       // userlistのuserIdの取得
       $user_id = $request->input('userId');
       //$user_idと同じ値があるレコードを取得
       $data = User::find($user_id);
       //保存ボタンを押したときに処理をする
       if ($request->isMethod('post') == true) {
           //フォームの内容をすべて取得
           $data = $request->validate([
             //バリデーション追加
             'password'                   =>'nullable|confirmed|min:8',
             'password_confirmation'      =>'nullable|min:8',
           ]);
           //配列にuser_id,name,email,role,passwordを追加
           $data['user_id'] =$request->input('user_id');
           $data['name'] = $request->input('name');
           $data['email'] = $request->input('email');
           $data['role'] = $request->input('role');
           $data['password'] = $request->input('password');
           //UserモデルのitemEditメソッドにアクセスし、データを編集
           $searchlist = User::userEdit($data);
           //現在認証されているユーザーの権限が1以外だったらログアウト
           if(($id ==  $data['user_id']) && ($data['role'] != 1)){
            Auth::logout();
           };
           //登録者一覧にリダイレクト
           return redirect()->route('userList');
      }
     //登録者編集画面へ
     return view('userEdit',compact('request','data','user_id'));
    }

    /**
     * ユーザー削除
     * @param Request $request
     * @return view
     */
     public function userDelete(Request $request)
     {
         // 現在認証されているユーザーの取得
         $user = Auth::user();
         // 現在認証されているユーザーのID取得
         $id = Auth::id();
         // userlistのuserIdの取得
         $user_id = $request->input('userId');
         //var_dump($data);
         //exit;
         // 現在認証されているユーザー以外のデータを
         //Userモデルのdeleteメソッドにアクセスし、データを削除
         if($id != $user_id){
         $delete = User::userDelete($user_id);
       }else{
         //商品検索へリダイレクト
         return redirect()->route('userList');
       }
         //削除メッセージを$msgに代入
         if ($delete === 0) {
            $msg= '削除失敗';
         } else {
            $msg = '削除しました';
         }
         //Userモデルのsearchメソッドにアクセスし、データを取得
         $list = User::all();

         return view('userList', compact('msg','list'));
    }

  }
