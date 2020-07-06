<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'goods_id';

    //DB項目
    protected $fillable = [
        'goods_name',
        'category',
        'type',
        'unit_price',
        'discount_number',
        'discount_rate',
        'stock',
        'item_info',
        'comment',
        'status',
        'created_at',
        'updated_at',
    ];


    /**
     * データを保存する
     *
     * @param array  $data
     * @return string $data
     */
    public static function insert($data) {
        $input_date = [
            'goods_name'      => $data['goods_name'],
            'category'        => $data['category'],
            'type'            => $data['type'],
            'unit_price'      => $data['unit_price'],
            'discount_number' => $data['discount_number'],
            'discount_rate'   => $data['discount_rate'],
            'stock'           => $data['stock'],
            'item_info'       => $data['item_info'],
            'comment'         => $data['comment'],
            'status'          => $data['status'],
            'created_at'      => now(),
        ];
        self::create($input_date);

        return $data;
    }

    /**
     * データを編集する
     *
     * @param array  $data
     * @return string $data
     */
    public static function edit($data) {
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['goods_id']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> goods_name = $data['goods_name'];
            $edit_data -> category   = $data['category'];
            $edit_data -> type       = $data['type'];
            $edit_data -> unit_price = $data['unit_price'];
            $edit_data -> discount_number = $data['discount_number'];
            $edit_data -> discount_rate = $data['discount_rate'];
            $edit_data -> stock   = $data['stock'];
            $edit_data -> item_info       = $data['item_info'];
            $edit_data -> status = $data['status'];
            $edit_data -> updated_at = now();
            $edit_data -> save();
            return $data;
        } else {
             return false;
        }
    }


    /**
     * item_name,apply,selector,create_userを指定してデータを取得する
     *@param int  $create_uder
     *@return array|null
     *
     */
    public static function search ($data, $limit=10) {
        //SQL文が使え、->が使えるようになる
        $search_data = self::query();

        if ($data['goods_name']) {
            $search_data -> where('goods_name',$data['goods_name']);
        }

        if ($data['category'] !== 'null') {
            $search_data -> where('category',$data['category']);
        }

        if (count($data['item_info']) == 1) {
            $search_data -> whereRaw('FIND_IN_SET(?, item_info)',[$data['item_info']]);
        } elseif (count($data['item_info']) >= 2) {
            $search_data -> whereRaw('FIND_IN_SET(?,item_info)',[$data['item_info'][0]]);
            for($i=1;$i<count($data['item_info']);$i++)
                {
                    $search_data->WhereRaw('FIND_IN_SET(?,item_info)',[$data['item_info'][$i]]);
                }
        }

        if ($data['stock'] == 1) {
            $search_data -> where('stock','>=',$data['stock']);
        } elseif ($data['stock'] == 0) {
            $search_data -> where('stock','=',$data['stock']);
        }

        $search_data -> leftJoin('purchase','goods.goods_id','=','purchase.goods_id')
                     ->select('goods.*','purchase.purchase_number');

        return $search_data ->paginate($limit);
    }

    /**
     * goods_idと同じデータを取得する
     *@param int  $create_uder
     *@return array|null
     *
     */
    public static function find_goods ($purchase_button) {

        foreach ($purchase_button as $key => $value) {
        $search_data = self::where('goods_id', $key)
                ->chunk(10, function ($purchase_button) {
                    $purchase_button->touch();
                }
            );
                 //->get();
                 //echo $search_data;
                 //var_dump($search_data);
                 //exit;
        }
             //$search_data ->get();
        var_dump($search_data);
        exit;

        //return $search_data;
    }

}