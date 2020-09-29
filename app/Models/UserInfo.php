<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserInfo extends Model
{
    /**
    * テーブルの主キー
    *
    * @var int
    */
    //protected $primaryKey = 'id';
    protected $table = 'user_info';

    //DB項目
    public $fillable = [
        'last_name'      => 'last_name',
        'name'           => 'name',
        'last_name_kana' => 'last_name_kana',
        'name_kana'      => 'name_kana',
        'gender'         => 'gender',
        'status'         => 'status',
        'id'             => 'id',
        'birthday_day'   => 'birthday_day',
        'created_at'     => 'created_at',
        'updated_at'     => 'updated_at',
        'deleted_at'     => 'deleted_at'
    ];

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string|null
     */
    public static function insert($data)
    {
        $input_date = [
            'last_name'         => $data['last_name'],
            'name'              => $data['name'],
            'last_name_kana'    => $data['last_name_kana'],
            'name_kana'         => $data['name_kana'],
            'gender'            => $data['gender'],
            'status'            => $data['status'],
            'birthday_day'      => $data['birthday_day'],
            'created_at'        => now(),
            'updated_at'        => null,
            'deleted_at'        => null,
        ];
        self::create($input_date);
    }


    /**
    * データを編集する
    *
    * @param array  $data
    * @return array|null
    */
    public static function edit($data)
    {
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['id']);
        //$data[item_id]があるとき保存の処理が行われる。
        if ($edit_data) {
            $edit_data -> last_name = $data['last_name'];
            $edit_data -> name = $data['name'];
            $edit_data -> last_name_kana = $data['last_name_kana'];
            $edit_data -> name_kana = $data['name_kana'];
            $edit_data -> gender = $data['gender'];
            $edit_data -> status = $data['status'];
            $edit_data -> birthday_day = $data['birthday_day'];
            $edit_data -> updated_at = now();
            $edit_data -> save();
        } else {
            return false;
        }
    }

    /**
     * データを削除する
     *
     * @param array  $data
     * @return string|null
     */
    public static function userDelete($data)
    {
        //$edit_dataにDBから$data[item_id]と同じ値を取得する。
        $edit_data = self::find($data['id']);
        //論理削除がおこなわれる。status==1
        if ($edit_data) {
            $edit_data -> status = $data['status'];
            $edit_data -> deleted_at = now();
            $edit_data -> save();
        } else {
            return false;
        }
    }
}
