<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'item_id';

    //DB項目
    protected $fillable = ['item_id', 'item_name', 'item_name_kana',
                           'apply', 'selector', 'price', 'create_user',
                           'update_user','id'];
    //種別の配列
    public static $type = [
        1 => '備品',
        2 => '私物',
    ];

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string|null
     */
    public static function insert($data)
    {
        $input_date = [
            'item_name'         => $data['item_name'],
            'item_name_kana'    => $data['item_name_kana'],
            'apply'             => $data['apply'],
            'selector'          => $data['selector'],
            'price'             => $data['price'],
            'create_user'       => $data['create_user'],
            'created_at'        => now(),
        ];
        self::create($input_date);

        return;
    }

    /**
     * データを全て取得する
     *
     * @param array  $data
     * @return string|null
     */
    public static function itemList($data)
    {
        $data = self::where('create_user', $data['create_user'])
              //usersテーブルと内部結合しデータを取得
              ->join('users', 'id', '=', 'create_user')
              ->paginate(5);

        return $data;
    }

    /**
     * create_userを指定してデータを取得する
     *
     * @param int  $create_uder
     * @return array|null
     */
    public static function findCreateUser($create_uder = null)
    {
        $request = self::where('create_user', $create_uder)
                 ->get();
        return $request;
    }
    /**
     * item_name,apply,selector,create_userを指定してデータを取得する
     *@param int  $create_uder
     *@return array|null
     *
     */
    public static function search($data, $limit = 5)
    {
        //SQL文が使え、->が使えるようになる
        $search_data = self::query();
        //usersテーブルと内部結合
        if ($data['create_user']) {
            $search_data -> join('users', 'id', '=', 'create_user');
        }

        if ($data['create_user']) {
            $search_data -> where('create_user', $data['create_user']);
        }

        if ($data['item_name']) {
            $search_data -> where('item_name', $data['item_name']);
        }

        if ($data['item_name_kana']) {
            $search_data -> where('item_name_kana', $data['item_name_kana']);
        }

        if ($data['apply']) {
            $search_data -> where('apply', $data['apply']);
        }

        if ($data['selector'] && $data['selector'] != 99) {
            $search_data -> where('selector', $data['selector']);
        }

        if ($data['price']) {
            $search_data -> where('price', $data['price']);
        }

        if ($data['date_start']) {
            $search_data -> where('created_at', '>=', $data['date_start']);
        }

        if ($data['date_end']) {
            $search_data -> where('created_at', '<=', $data['date_end'] . ' 23:59:59');
        }

        $data = self::join('users', 'id', '=', 'create_user')
              ->select('name');

        return $search_data ->paginate($limit);
    }


    public static function itemDelete($data)
    {
        $data = self::where('item_id', $data)->delete();
        return $data;
    }


    public static function itemEdit($data)
    {
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['item_id']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> item_name = $data['item_name'];
            $edit_data -> item_name_kana = $data['item_name_kana'];
            $edit_data -> apply = $data['apply'];
            $edit_data -> selector = $data['selector'];
            $edit_data -> price = $data['price'];
            $edit_data -> save();
        } else {
             return false;
        }
    }
}
