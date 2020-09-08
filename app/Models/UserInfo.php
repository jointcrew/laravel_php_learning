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
    protected $fillable = [
        'last_name',
        'name',
        'last_name_kana',
        'name_kana',
        'gender',
        'birthday_day',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
    * データを登録する
    *
    * @param array  $data
    * @return array|null
    */
    public static function insert($data) {

    }

}
