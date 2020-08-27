<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Goods;
use App\Models\Purchase;
use App\Models\User;
use App\Rules\nomal_number;

class GoodsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $discount_number = \Lang::get('goods.discount_number');
        $category        = \Lang::get('goods.category');
        $type            = \Lang::get('goods.type');
        $status          = \Lang::get('user.status');
        $item_info       = \Lang::get('goods.item_info');
        $stock           = \Lang::get('goods.stock');
        $discount_number = \Lang::get('goods.discount_number');
        $status          = \Lang::get('user.status');
        $userlist_status = \Lang::get('user.userlist_status');
        $roles           = \Lang::get('user.role_name');

        //一気に送りたい
        View::share('discount_number', $discount_number);
        View::share('category', $category);
        View::share('type', $type);
        View::share('status', $status);
        View::share('item_info', $item_info);
        View::share('stock', $stock);
        View::share('discount_number', $discount_number);
        View::share('userlist_status', $userlist_status);
        View::share('roles', $roles);
    }

    /**
     * 検索画面
     * @param Request $request
     * @return view
     */
    public function goodsSearch(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        //バリデーション
        $data = $request->validate([
           'goods_name'       =>'max:50',
        ]);
        $data = [
            'goods_name'      => $request->input('goods_name'),
            'category'        => $request->input('category'),
            'stock'           => $request->input('stock'),
            'item_info'       => $request->input('item_info_1').','.$request->input('item_info_2'),
        ];
        $data['item_info'] = explode(",", $data['item_info']);
        $data['item_info'] = array_filter($data['item_info']);
        //Goodsモデルのsearchメソッドにアクセスし、データを取得
        $searchlist = Goods::search($data);
        return view('goodsSearch',compact('searchlist','role','request','data'));
    }

    /**
     * 商品詳細
     * @param Request $request
     * @return view
     */
    public function goodsDetail(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        //商品IDを取得(検索画面からの遷移時)
        $data['goods_id'] = $request->input('goods_id');
        //$good_idと同じ値があるレコードを取得
        $data = Goods::find($data['goods_id']);
        //総購入数を取得(検索画面からの遷移時)
        $data['total_purchase_number'] = $request->input('total_purchase_number');
        //item_infoのカンマを外し配列に、空は排除
        if (isset($data['item_info'])) {
            $data['item_info'] = explode(",", $data['item_info']);
            $data['item_info'] = array_filter($data['item_info']);
        }

        return view('goodsEdit',compact('data','role'));
    }


    /**
     * 決済前画面(一般ユーザー)
     * @param Request $request
     * @return view
     */
    public function beforeSettle(Request $request)
    {
        // 現在認証されているユーザーのID取得
        $id = Auth::id();
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        //商品IDを取得(検索画面からの遷移時)
        $data['goods_id'] = $request->input('goods_id');
        //$good_idと同じ値があるレコードを取得
        $data = Goods::find($data['goods_id']);
        //総購入数を取得(検索画面からの遷移時)
        $data['total_purchase_number'] = $request->input('total_purchase_number');

        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            //検索画面から一度に複数商品購入かどうかのflag
            $all_once_flag = $request->input('all_once_flag');
            //単一商品購入
            if (is_null($all_once_flag)) {
                $validatedData  = $request->validate([
                    'purchase_number' => "required|integer|max:{$data['stock']}"
                ]);
                //購入数を$dataに挿入
                $data['purchase_number'] = $request->input('purchase_number');
                //表示金額を計算
                $data = $this->calculate($data);
                //決済画面へ
                return view('goodsSettle',compact('data','role'));
            //複数商品購入
            } elseif (!is_null($all_once_flag)) {
                //購入数(複数商品なので配列で)を$dataに挿入
                $purchase_numbers = $request->input('purchase_number');
                //すべての購入数が0だったら、検索画面へリダイレクト
                $check = $this->purchase_numbers_check($purchase_numbers);
                if (!is_null($check)) {
                    return redirect()->back();
                }
                //購入数を入力していない商品idを外す
                $purchase_numbers = array_filter($purchase_numbers);
                //find_goodsメソッドでデータを取得をす得するため、渡す変数をgoods_idの配列に直す。
                //key(goods_id)を取り出す。
                $goods_IDs = array_keys($purchase_numbers);
                //Goodsモデルのfind_goodsメソッドにアクセスし、同goods_idデータを取得
                $datalist = Goods::find_goods($goods_IDs);
                //購入数が在庫を上回っていたらリダイレクト
                foreach ($datalist as $data) {
                    $data["stock"] = ($data["stock"]) - ($purchase_numbers[$data["goods_id"]]);
                    if ($data["stock"]<0) {
                        return redirect()->back();
                    }
                }
                //表示金額を計算
                $datalist = $this->all_once_calculate($datalist,$purchase_numbers);
                $total_data = [
                    'purchase_number'       => array_sum($datalist['purchase_numbers']),
                    'discount_price'        => array_sum($datalist['discount_price']),
                    'total_price'           => array_sum($datalist['total_price']),
                    'purchase_price'        => array_sum($datalist['purchase_price'])
                ];
                //決済画面へ
                return view('goodsSettle',compact('datalist','total_data','role','id'));
            }
        }
    }

    /**
     * 決済処理
     * @param Request $request
     * @return view
     */
    public function goodsSettle(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーのID取得
        $id = Auth::id();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            //DB挿入データを取得
            $data = [
                'goods_id'             => $request->input('goods_id'),
                'unit_price'           => $request->input('unit_price'),
                'purchase_numbers'     => $request->input('purchase_numbers'),
                'total_price'          => $request->input('total_price'),
                'discount_price'       => $request->input('discount_price'),
                'purchase_price'       => $request->input('purchase_price'),
                'goods_stock'          => $request->input('goods_stock'),
                'user_id'              => $id
            ];
            //購入後の在庫数取得
            $multi_goods_stock = $request->input('multi_goods_stock');
            //複数購入のフラグ
            $all_once_flag = $request->input('all_once_flag');
            if (!is_null($all_once_flag)) {
                //DBに保存するためuser_idが必要
                $data['user_id'] = $request->input('user_id');
                //複数商品決済
                $insert_data = Purchase::insert_all($data,$multi_goods_stock);
            } else {
                //在庫数更新
                $data['goods_stock'] = ($data['goods_stock']) - ($data['purchase_numbers']);
                //単一商品決済
                $insert_data = Purchase::inserts($data);
            }
            //文言を$msgに代入
            if ($insert_data == null) {
               $msg= \Lang::get('goods.goods_Settle.2');
            } else {
               $msg =\Lang::get('goods.goods_Settle.1');
            }
            return view('goodsSearch',compact('role','request','msg'));
        }
        return view('goodsSearch',compact('role','request'));
    }



    /**
     * 商品登録・編集(管理者)
     * @param Request $request
     * @return view
     */
    public function goodsEdit(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        //商品IDを取得(検索画面からの遷移時)
        $data['goods_id'] = $request->input('goods_id');
        //$good_idと同じ値があるレコードを取得
        $data = Goods::find($data['goods_id']);
        //総購入数を取得(検索画面からの遷移時)
        $data['total_purchase_number'] = $request->input('total_purchase_number');
        //item_infoのカンマを外し配列に、空は排除
        if (isset($data['item_info'])) {
            $data['item_info'] = explode(",", $data['item_info']);
            $data['item_info'] = array_filter($data['item_info']);
        }
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            //フォームの内容をすべて取得
            $data = $request->validate([
               //バリデーション追加
               'category'          =>'integer',
               'type'              =>'integer',
               'goods_name'        =>'required|string|max:50',
               'unit_price'        =>'required|integer|max:100000',
               'discount_number'   =>'required',
               'stock'             =>'required|integer|max:100000',
               'comment'           =>'max:250',
               'status'            =>'required',
           ]);
            //配列にitem_infoを追加
            $item_info = \Lang::get('goods.item_info');
            $length = count($item_info);
            foreach ($item_info as $key => $value) {
                if ($key < $length) {
                    $data['item_info'] = $request->input("item_info.$key").',';
                } elseif ($key == $length) {
                    $data['item_info'] .= $request->input("item_info.$key");
                }
            }
            //割引があれば率を10%に
            if ($data['discount_number'] == 0) {
                $data['discount_rate'] = 0;
            } else {
                $data['discount_rate'] = 10;
            }
            //商品IDを取得(検索画面からの遷移時)
            $data['goods_id'] = $request->input('goods_id');
            //商品編集
            if (!is_null($data['goods_id'])) {
                //Goodsモデルのeditメソッドにアクセスし、データを編集
                $insert_data = Goods::edit($data);
                //文言を$msgに代入
                if ($insert_data == null) {
                   $msg= \Lang::get('goods.goods_Edit.2');
                } else {
                   $msg =\Lang::get('goods.goods_Edit.1');
                }
            } else {
                //商品登録
                //Goodsモデルのinsertメソッドにアクセスし、データを保存
                $insert_data = Goods::insert($data);
                //文言を$msgに代入
                if ($insert_data == null) {
                   $msg= \Lang::get('user.user_register_fail');
                } else {
                   $msg =\Lang::get('user.user_register_success');
                }
            }
            //総購入数を取得(検索画面からの遷移時)
            $data['total_purchase_number'] = $request->input('total_purchase_number');
            //item_infoのカンマを外し配列に、空は排除
            $data["item_info"] = explode(",", $data['item_info']);
            $data["item_info"] = array_filter($data['item_info']);

            return view('goodsEdit',compact('msg','data','role'));
        }
        //商品新規登録
        return view('goodsEdit',compact('data','role'));
    }

    /**
     * ユーザー管理
     * @param Request $request
     * @return view
     */
    public function goodsUser(Request $request)
    {
        //現在認証されているユーザーの全商品を取得
        $userlist = User::paginate(10);
        return view('goodsUser',compact('userlist'));
    }

    /**
     * ユーザー編集
     * @param Request $request
     * @return view
     */
    public function goodsUserEdit(Request $request)
    {
        //商品IDを取得(検索画面からの遷移時)
        $data['user_id'] = $request->input('user_id');
        //$good_idと同じ値があるレコードを取得
        $data = User::find($data['user_id']);

        if ($request->isMethod('post') == true) {

            $user_id = $request->input('user_id');
            //ユーザー新規登録
            if (is_null($user_id)) {
                $data = $request->validate([
                   //バリデーション追加
                   'name'                    =>'required|string|max:30',
                   'email'                   =>'required|email|unique:App\User,email|max:150',
                   'pass'                    =>'confirmed|min:8',
                   'pass_confirmation'       =>'nullable|min:8',
                   'status'                  =>'required|integer|max:10',
                   'role'                    =>'required|integer|max:10',
               ]);
                //ユーザー登録
                //Goodsモデルのinsertメソッドにアクセスし、データを保存
                $insert_data = User::goodsUserInsert($data);

                //文言を$msgに代入
                if ($insert_data == null) {
                   $msg= \Lang::get('user.user_register_fail');
                } else {
                   $msg =\Lang::get('user.user_register_success');
                }
                return view('goodsUser',compact('msg','insert_data'));
            //ユーザー編集
            } elseif(!is_null($user_id)) {

                $data = $request->validate([
                   //バリデーション追加
                   'name'                    =>'required|string|max:30',
                   'email'                   =>'required|email|max:150',
                   'pass'                    =>'confirmed|min:8|nullable',
                   'pass_confirmation'       =>'nullable|min:8|nullable',
                   'status'                  =>'required|integer|max:10',
                   'role'                    =>'required|integer|max:10',
               ]);
                //Userモデルのeditメソッドにアクセスし、データを編集
                $insert_data = User::goodsUserEdit($data,$user_id);
                //文言を$msgに代入
                if ($insert_data == null) {
                   $msg= \Lang::get('goods.goods_Edit.2');
                } else {
                   $msg =\Lang::get('goods.goods_Edit.1');
                }
                return view('goodsUser',compact('msg','insert_data'));
            }
        }
    return view('goodsUserEdit',compact('data','request'));
    }
}
