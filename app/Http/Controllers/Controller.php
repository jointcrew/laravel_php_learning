<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const RESPONSE_CODE_200 = '200';
    const RESPONSE_CODE_400 = '400';
    const RESPONSE_CODE_401 = '401';
    const RESPONSE_CODE_402 = '402';
    const RESPONSE_CODE_403 = '403';
    const RESPONSE_CODE_404 = '404';
    const RESPONSE_CODE_405 = '405';
    const RESPONSE_CODE_406 = '406';
    const RESPONSE_CODE_407 = '407';
    const RESPONSE_CODE_408 = '408';
    const RESPONSE_CODE_409 = '409';


    /**
     * 複数商品購入の際、購入数がすべて0ではないかチェック。
     * すべて0だった場合は前画面へリダイレクト
     * @param $purchase_numbers
     * @return $count == $number false
     */
    public function purchase_numbers_check($purchase_numbers)
    {
        $count = count($purchase_numbers);
        $number = 0;
        foreach ($purchase_numbers as $purchase_number) {
            if ($purchase_number == null or $purchase_number == 0)
            $number++;
        }
        if ($count == $number) {
            return false;
        }
    }
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
            $data['discount_price'] = ($data['unit_price']*$data['purchase_number']) * $rate;
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
    public function all_once_calculate($datalist,$purchase_numbers)
    {
        //割引額
        $discount_price = array();
        //合計金額
        $total_price = array();
        //請求金額
        $purchase_price = array();

        foreach ($datalist as $data){

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
