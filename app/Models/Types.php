<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'type_id';

    //DB項目
    protected $fillable = ['category_id', 'value_number','type_name','created_at','updated_at'];

    /**
     * item_name,apply,selector,create_userを指定してデータを取得する
     *@param int  $create_uder
     *@return array|null
     *
     */
    public static function search ($category_id){
        //SQL文が使え、->が使えるようになる
        $search_data = self::query();
        //usersテーブルと内部結合
        $search_data ->select('value_number','type_name')
                     -> where('category_id',$category_id);

        $types = $search_data ->get();

        return $types ;
     }

     /**
      * category_idを取得する
      *@param int  $create_uder
      *@return array|null
      *
      */
     public static function category_id_search ($type_vale){
         //SQL文が使え、->が使えるようになる
         $search_data = self::query();
         //usersテーブルと内部結合
         $search_data ->select('category_id')
                      -> where('value_number',$type_vale);

         $types = $search_data ->get();

         return $types ;
      }
}
