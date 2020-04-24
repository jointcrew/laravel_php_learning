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
    protected $fillable = ['item_id', 'item_name', 'apply', 'selector', 'price', 'create_user','update_user'];

    //種別の配列
    static $type = [
        1 => '備品',
        2 => '私物',
    ];

    static $aaa_id = 4;

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string|null
     */
    public static function insert($data) {
        $input_date = [
            'item_name'    => $data['item_name'],
            'apply'        => $data['apply'],
            'selector'     => $data['selector'],
            'price'        => $data['price'],
            'create_user' => $data['create_user'],
            'created_at'  => now(),
        ];
        self::create($input_date);

        return;
    }

    /**
     * create_userを指定してデータを取得する
     *
     * @param int  $create_uder
     * @return array|null
     */
    public static function findCreateUser ($create_uder = null) {
        $request = self::where('create_user', $create_uder)
                 ->get();
        return $request;
    }
    /**
     * item_name,apply,selector,create_userを指定してデータを取得する
     *
     *  @param int  $create_uder
     * @return array|null
     */
    public static function search ($data)
    {
        $search_data = self::query();
        //var_dump($data);
        //exit;
        if ($data['create_user']) {
            $search_data -> where('create_user',$data['create_user']);
        }

        if ($data['item_name']) {
            $search_data -> where('item_name',$data['item_name']);
        }

        if ($data['apply']) {
            $search_data -> where('apply',$data['apply']);
        }

        if ($data['selector'] && $data['selector'] != 99) {
            $search_data -> where('selector',$data['selector']);
        }

        if ($data['price']) {
            $search_data -> where('price',$data['price']);
        }

        if ($data['date_start']){
            $search_data -> where('created_at','>=', $data['date_start']);
        }

        if($data['date_end']){
            $search_data -> where('created_at','<=', $data['date_end'].' 23:59:59');
        }

      //  if($data['date_start'] and $data['date_end']){
        //    $search_data -> where('created_at', 'between', $data['date_start'], 'and', $data['date_end']);
          //}
       //var_dump($data);
       //exit;
        return $search_data ->get();
     }
   }
