<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'purchase_id';

    protected $table = 'purchase';

    //DB項目
    protected $fillable = [
        'goods_id',
        'unit_price',
        'purchase_number',
        'total_price',
        'discount_price',
        'purchase_price',
        'user_id',
        'created_at'
    ];

    public $timestamps = false;

    /**
     * データを保存する
     *
     * @param array  $data
     * @return $data
     */
    public static function inserts($data) {
        //トランザクション処理
        $insert = DB::transaction(function () use ($data) {
            $input_date = [
                'goods_id'        => $data['goods_id'],
                'unit_price'      => $data['unit_price'],
                'purchase_number' => $data['purchase_numbers'],
                'total_price'     => $data['total_price'],
                'discount_price'  => $data['discount_price'],
                'purchase_price'  => $data['purchase_price'],
                'user_id'         => $data['user_id'],
                'created_at'      => now(),
            ];
            self::create($input_date);

            //指定goods_id($data[item_id])のstockが更新される
            $edit_data = Goods::find($data['goods_id']);
            $edit_data -> stock = $data['goods_stock'];
            $edit_data -> updated_at = now();
            $edit_data -> save();

            return $data;
        });
        return $insert;
    }

    /**
     * データを保存する(複数商品購入の際)
     *
     * @param array  $data
     * @return array $insert_datas
     */
    public static function insert_all($data,$multi_goods_stock) {

        //トランザクション処理
        $insert = DB::transaction(function () use ($data,$multi_goods_stock) {
            foreach ($data['goods_id'] as $value) {
                //同じgoods_idを配列にして返す
                $datalist[] = array_column( $data, $value );
                $insert_datas = array();
                $keys = [
                    'goods_id',
                    'unit_price',
                    'purchase_number',
                    'total_price',
                    'discount_price',
                    'purchase_price',
                    'user_id'
                ];
                    foreach ($datalist as $val) {
                        //キー名と値をマッピングして連想配列を返却
                        $insert_data = array_combine($keys, $val);
                        $insert_data['created_at'] = now();
                        array_push($insert_datas,$insert_data);
                    }
                }
            self::insert($insert_datas);

            //指定goods_id($data[item_id])のstockが更新される
            foreach ($multi_goods_stock as $key => $stock) {
                $edit_data = Goods::find($key);
                $edit_data -> stock = $stock;
                $edit_data -> updated_at = now();
                $edit_data -> save();
            }
            return $insert_datas;
        });
        return $insert;
    }

}
