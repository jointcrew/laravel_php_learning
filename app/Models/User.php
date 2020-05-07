<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'id';

    //DB項目
    protected $fillable = ['id','name','email','role','created_at'];

    public static function userEdit ($data) {
      //var_dump($data);
      //exit;
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['user_id']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> name = $data['name'];
            $edit_data -> email = $data['email'];
            $edit_data -> role = $data['role'];
            $edit_data -> save();
        } else {
            return false;
        }
    }

 }
