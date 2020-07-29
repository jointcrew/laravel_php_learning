<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\katakana;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;


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
        //roleを定義
        $roles = \Lang::get('user.role_name');

        View::share('roles', $roles);
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
        }
        return view('items', compact('type_array','request'));
    }

     /**
      * 商品一覧画面
      * @param Request $request
      * @return view
      */
     public function itemList(Request $request)
     {
         // 現在認証されているユーザーのID取得
         $id = Auth::id();
         //配列に入力値を追加
         $data['create_user'] = $id;
         $data['item_name'] = $request->input('item_name');
         $data['item_name_kana'] = $request->input('item_name_kana');
         $data['apply'] = $request->input('apply');
         $data['selector'] = $request->input('selector');
         $data['price'] = $request->input('price');
         $data['date_start'] = $request->input('date_start');
         $data['date_end'] = $request->input('date_end');
         //現在認証されているユーザーの全商品を取得
         $list = Item::itemList($data);

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

        return view('itemsearch', compact('searchlist','request','data'));
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
            $msg= \Lang::get('item.delete_fail');
         } else {
            $msg = \Lang::get('item.delete_success');
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
             //配列に入力値を追加
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
        $create_user_id = Auth::id();
        //Userモデルから全件データを取得する。
        $list = User::all();

        return view('userList',compact('list','create_user_id'));
    }

    /**
     * ユーザー検索(rest apiを実行)
     * @param Request $request
     * @return view
     */
    public function userApiSearch(Request $request)
    {
        // 現在認証されているユーザーのID取得
        $create_user_id = Auth::id();
        //APIをつかって取得
        try {
            //http通信を行う
            $client = new Client();
            $url = \Config::get('services.user_api_url.restapi');
            //idを取得
            $get_id = $request->input('get_id');
            //$urlに/,$get_idを付け加える
            $url = $url.'/'.$get_id;
            $response = $client->request("GET", $url );
            //getBody()でAPIの結果を取得
            $list = $response->getBody();
            //json_decodeで配列型に変換
            $list = json_decode($list, true);
            //$list["response"]だけ取り出す
            $list = $list["response"];
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }

        return view('userList',compact('list','create_user_id'));
    }

    /**
     * ユーザー登録(rest apiを実行)
     * @param Request $request
     * @return view
     */
    public function userApiRegister(Request $request)
    {
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            // 現在認証されているユーザーのID取得
            $create_user_id = Auth::id();
            $data = $request->validate([
                //バリデーション追加
                'name'                   =>  'required|string|max:30',
                'email'                  =>  'required|email|unique:App\User,email|max:150',
                'role'                   =>  'required|integer|max:10',
                'password'               =>  'confirmed|min:8',
                'password_confirmation'  =>  'nullable|min:8',
            ]);
            //APIをつかって取得
            try {
                //http通信を行う
                $client = new Client();
                $url = \Config::get('services.user_api_url.restapi');
                $option = [
                    'form_params' =>
                    [
                        'name'               => $data['name'],
                        'email'              => $data['email'],
                        'password'           => $data['password'],
                        'role'               => $data['role'],
                        'created_at'         => now(),
                    ]
                ];
                $response = $client->request("POST", $url, $option );
                //getBody()でAPIの結果を取得
                $insert_list = $response->getBody();
                //json_decodeで配列型に変換
                $insert_list = json_decode($insert_list, true);
                //$insert_listに["response"]だけ取り出す
                $insert_list = $insert_list["response"];
                $list = array();
                $list[0] = $insert_list;
                //文言を$msgに代入
                if ($list[0] == null) {
                   $msg= \Lang::get('user.user_register_fail');
                } else {
                   $msg =\Lang::get('user.user_register_success');
                }

            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                //アクセス失敗したらエラーを返す
                return $e->getHandlerContext()['error'];
            }
            return view('userList',compact('list','msg','create_user_id'));
        }
        return view('userList');
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
             if (($id ==  $data['user_id']) && ($data['role'] != 1)) {
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
         $create_user_id = Auth::id();
         // userlistのuserIdの取得
         $user_id = $request->input('userId');
         // 現在認証されているユーザー以外のデータを
         //Userモデルのdeleteメソッドにアクセスし、データを削除
         if ($create_user_id != $user_id) {
             $delete = User::userDelete($user_id);
         } else {
           //ユーザーリストへリダイレクト
           return redirect()->route('userList');
         }
         //削除メッセージを$msgに代入
         if ($delete === 0) {
             $msg = \Lang::get('item.delete_fail');
         } else {
             $msg = \Lang::get('item.delete_success');
         }
         //Userモデルのsearchメソッドにアクセスし、データを取得
         $list = User::all();

         return view('userList', compact('msg','list','create_user_id'));
    }
}
