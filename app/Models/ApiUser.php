<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiUser extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'user_id';

    //DB項目
    protected $fillable = ['user_name', 'age', 'create_user_id', 'create_user_name', 'created_at', 'updated_at'];


     /**
     * データを登録する
     *
     * @param array  $data
     * @return string|null
     */
    public static function insert($data) {
        $input_date = [
            'user_name'         => $data['user_name'],
            'age'               => $data['age'],
            'create_user_id'    => $data['create_user_id'],
            'create_user_name'  => $data['create_user_name'],
            'created_at'        => now(),
        ];
        self::create($input_date);

        return $data;
    }
     /**
     * データを編集する
     *
     * @param array  $data
     * @return string|null
     */
     public static function apiUserEdit ($data) {
         //$edit_dataにDBから$data[id]と同じ値を取得する。
         $edit_data = self::find($data['id']);
         //$data[put_id]があるとき保存の処理が行われる。
         if ($edit_data) {
         if ($data['user_name']){
            $edit_data -> user_name = $data['user_name'];
            }
            if($data['age']){
              $edit_data -> age = $data['age'];
            }
              $edit_data -> save();
         } else {
              return false;
         }
         return $data;
     }
    /**
    * データを削除する
    *
    * @param array  $data
    * @return string|null
    */
    public static function apiUserDelete ($data) {
        //トランザクション処理
        DB::transaction(function () use ($data) {
        //同じIDのレコードを削除
        $data = self::where('user_id',$data['id'])->delete();

        return $data;
        });
    }
}
