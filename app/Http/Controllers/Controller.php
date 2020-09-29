<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public const RESPONSE_CODE_200 = '200';
    public const RESPONSE_CODE_400 = '400';
    public const RESPONSE_CODE_401 = '401';
    public const RESPONSE_CODE_402 = '402';
    public const RESPONSE_CODE_403 = '403';
    public const RESPONSE_CODE_404 = '404';
    public const RESPONSE_CODE_405 = '405';
    public const RESPONSE_CODE_406 = '406';
    public const RESPONSE_CODE_407 = '407';
    public const RESPONSE_CODE_408 = '408';
    public const RESPONSE_CODE_409 = '409';


    /**
     * 単一商品の際、決済前表示のための計算処理
     * @param $data
     * @return $data
     */
    public function calculate($data)
    {
        //割引額を計算
        $data['discount_price'] = 0;
        if ($data['discount_rate'] > 0 && $data['purchase_number'] >= $data['discount_number']) {
            $rate =  $data['discount_rate'] * 0.01;
            $data['discount_price'] = ($data['unit_price'] * $data['purchase_number']) * $rate;
        }
        //合計金額を計算
        $data['total_price'] = $data['unit_price'] * $data['purchase_number'];
        //請求金額を計算
        $data['purchase_price'] = ($data['unit_price'] * $data['purchase_number']) - $data['discount_price'];
        return $data;
    }

    /**
     * 複数商品の際、決済前表示のための計算処理
     * @param $datalist,$purchase_numbers
     * @return $datalist
     */
    public function allOnceCalculate($datalist, $purchase_numbers)
    {
        //割引額
        $discount_price = array();
        //合計金額
        $total_price = array();
        //請求金額
        $purchase_price = array();

        foreach ($datalist as $data) {
            //割引額を計算
            $data['discount_price'] = 0;
            if ($data['discount_rate'] > 0 && $purchase_numbers[$data['goods_id']] >= $data['discount_number']) {
                $rate =  $data['discount_rate'] * 0.01;
                $data['discount_price'] = ($data['unit_price'] * $purchase_numbers[$data['goods_id']]) * $rate;
            }

            //合計金額を計算
            $data['total_price'] = $data['unit_price'] * $purchase_numbers[$data['goods_id']];
            //請求金額を計算
            $data['purchase_price'] = ($data['unit_price'] * $purchase_numbers[$data['goods_id']]) - $data['discount_price'];

            $discount_price[$data['goods_id']] = $data['discount_price'];
            $total_price[$data['goods_id']]    = $data['total_price'];
            $purchase_price[$data['goods_id']] = $data['purchase_price'];
        }

        $datalist['purchase_numbers'] = $purchase_numbers;
        $datalist['discount_price']   = $discount_price;
        $datalist['purchase_price']   = $purchase_price;
        $datalist['total_price']      = $total_price;

        return $datalist;
    }
}
