<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
