<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'category_id';

    //DB項目
    protected $fillable = ['category_name', 'created_at','created_at', 'updated_at'];
}
