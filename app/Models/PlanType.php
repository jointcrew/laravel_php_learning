<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'id';

    protected $table = 'plan_type';

    //DB項目
    protected $fillable = ['insurance_name', 'insurance_fee', 'created_at', 'updated_at'];
}
