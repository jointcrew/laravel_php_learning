<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * @return string $data
     */
    public static function inserts($data) {
        $input_date = [
            'goods_id'        => $data['goods_id'],
            'unit_price'      => $data['unit_price'],
            'purchase_number' => $data['purchase_number'],
            'total_price'     => $data['total_price'],
            'discount_price'  => $data['discount_price'],
            'purchase_price'  => $data['purchase_price'],
            'user_id'         => $data['user_id'],
            'created_at'      => now(),
        ];
        self::create($input_date);

        return $data;
    }

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string $data
     */
    public static function insert_all($data) {

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
        return $insert_datas;
    }
}
