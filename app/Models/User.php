<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    /**
    * テーブルの主キー
    *
    * @var int
    */
    protected $primaryKey = 'id';

    //DB項目
    protected $fillable = ['id','name','email','password','role','created_at'];

    /**
    * データを登録する
    *
    * @param array  $data
    * @return array|null
    */
    public static function insert($data) {
        //トランザクション処理
        $insert = DB::transaction(function () use ($data) {
            //pwハッシュ化
            $data['password'] = Hash::make($data['password']);
            $input_data = [
                'name'                => $data['name'],
                'email'               => $data['email'],
                'password'            => $data['password'],
                'role'                => $data['role'],
                'created_at'          => now(),
            ];
            $id = self::insertGetId($input_data);
            if ($id) {
                return self::find($id);
            }
            return $id;
        });
        return $insert;
    }

    /**
    * データを登録する
    *
    * @param array  $data
    * @return array|null
    */
    public static function goodsUserInsert($data) {
        //トランザクション処理
        $insert = DB::transaction(function () use ($data) {
            //pwハッシュ化
            $data['pass'] = Hash::make($data['pass']);
            $input_data = [
                'name'                => $data['name'],
                'email'               => $data['email'],
                'password'            => $data['pass'],
                'role'                => $data['role'],
                'status'              => $data['status'],
                'created_at'          => now(),
            ];
            $input_data['id'] = self::insertGetId($input_data);
            return $input_data;
        });
        return $insert;
    }

    /**
    * データを編集する
    *
    * @param array  $data
    * @return array|null
    */
    public static function userEdit ($data) {

        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['user_id']);
        //pwハッシュ化
        $data['password']=Hash::make($data['password']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> name = $data['name'];
            $edit_data -> email = $data['email'];
            $edit_data -> role = $data['role'];
            $edit_data -> password = $data['password'];
            $edit_data -> save();
        } else {
            return false;
        }
    }

    public static function userDelete ($user_id) {

        $user_id = self::where('id',$user_id)->delete();

        return $user_id;
    }

    /**
    * データを編集する
    *
    * @param array  $data
    * @return array|null
    */
    public static function goodsUserEdit ($data,$user_id) {
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($user_id);
        if (!is_null($data['pass'])) {
            //pwハッシュ化
            $data['password']=Hash::make($data['pass']);
        } elseif (is_null($data['pass'])) {
            //pwハッシュ化
            $data['password']=Hash::make($edit_data['password']);
        }
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> name = $data['name'];
            $edit_data -> email = $data['email'];
            $edit_data -> role = $data['role'];
            $edit_data -> status = $data['status'];
            $edit_data -> password = $data['password'];
            $edit_data -> save();
        } else {
            return $edit_data = null;
        }
        return $edit_data;
    }

    /**
     * 検索条件を指定してデータを取得する
     *@param int  $create_uder
     *@return array $insert_datas
     *
     */
    public static function search ($data) {

        $lists = array();
        $names = array();
        //配列に直す
        $data['user_id'] = explode(",", $data['user_id']);

            $search_data = self::query();
            $search_data ->select('users.id','users.name','goods.goods_name','purchase.purchase_number','purchase.total_price','purchase.created_at','purchase.discount_price')
                         -> leftJoin('purchase','users.id','=',"purchase.user_id")
                         -> leftJoin('goods','goods.goods_id','=',"purchase.goods_id");

            //商品名検索、likeにして部分一致のを取得にする
            if ($data['goods_name']) {
                $search_data ->where('goods.goods_name','like','%'.$data['goods_name'].'%');
            }

            if (!($data['category']=='null')) {
                $search_data ->where('goods.category',$data['category']);
            }

            if ($data['price_start']) {
                $search_data -> where('purchase.purchase_price','>=', $data['price_start']);
            }

            if ($data['price_end']) {
                $search_data -> where('purchase.purchase_price','<=', $data['price_end']);
            }

            if ($data['date_start']) {
                $search_data -> where('purchase.created_at','>=', $data['date_start']);
            }

            if ($data['date_end']) {
                $search_data -> where('purchase.created_at','<=', $data['date_end'].' 23:59:59');
            }

            if (!($data['user_id'][0] == '')) {

                if (count($data['user_id']) == 1) {
                    $search_data -> whereRaw('FIND_IN_SET(?, purchase.user_id)',[$data['user_id'][0]]);
                } elseif (count($data['user_id']) >= 2) {
                    $search_data -> whereRaw('FIND_IN_SET(?,purchase.user_id)',[$data['user_id'][0]]);
                    for($i=1;$i<count($data['user_id']);$i++) {
                        $search_data->orWhereRaw('FIND_IN_SET(?,purchase.user_id)',[$data['user_id'][$i]]);
                    }
                }
            }
        //検索結果を取得
        $list = $search_data ->paginate(10);
        return \Response::json($list);
    }

    /**
     * 利用冊数をカウント、４冊以上はfalse
     *@param int  $data
     *@return false
     *
     */
    public function checkRentBookNumber() {
        //rent_booksを取得
        $rent_books = $this->rent_books;
        //2冊までだったら、現冊数に+1
        if ((0 <= $rent_books) && ($rent_books < 3)) {
            $this->increment('rent_books', 1);
        } else {
            return false;
        }
        $this->save();

    }

    /**
     * 利用冊数を-1
     *@param int  $data
     *
     */
    public function cutBackBookNumber() {
        //rent_booksを取得
        $rent_books = $this->rent_books;
        //３冊までだったら、現冊数に-1
        if ((0 <= $rent_books) && ($rent_books < 3)) {
            $this->decrement('rent_books', 1);
        } else {
            return false;
        }
        $this->save();

    }

}
