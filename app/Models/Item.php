<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'sample_id';

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
            'item_id' => $data['item_id'],
            'item_name'        => $data['item_name'],
            'apply'       => $data['apply'],
            'selector' => $data['selector'],
            'price' => $data['price'],
            'created_user' => now(),
            'update_user' => now(),
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
}
