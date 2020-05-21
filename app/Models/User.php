<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'id';

    //DB項目
    protected $fillable = ['id','name','email','password','role','created_at'];

    /**
    * データを登録する
    *
    * @param array  $data
    * @return string|null
    */
   public static function insert($data) {

       //pwハッシュ化
       $data['password'] = Hash::make($data['password']);
       $input_date = [
           'name'                => $data['name'],
           'email'               => $data['email'],
           'password'            => $data['password'],
           'role'                => $data['role'],
           'created_at'          => now(),
       ];
       self::create($input_date);

       return $data;
   }

    public static function userEdit ($data) {

        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['user_id']);
        //pwハッシュ化
        $data['password']=Hash::make($data['password']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> name = $data['name'];
            $edit_data -> email = $data['email'];
            $edit_data -> role = $data['role'];
            $edit_data -> password = $data['password'];
            $edit_data -> save();
        } else {
            return false;
        }
    }

    public static function userDelete ($user_id) {

      $user_id = self::where('id',$user_id)->delete();

      return $user_id;
    }


 }
