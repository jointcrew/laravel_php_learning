<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'id';

    protected $table = 'books';

    //DB項目
    protected $fillable = [
        'id',
        'author',
        'title',
        'description',
        'status',
        'rent_count',
        'usecreated_atr_id',
        'created_at',
        'updated_at'
    ];

    public const AVAILABLE = 1;
    public const LOANEDOUT = 2;

    public function checkOut($rent_status, $rent_user_id)
    {
        if ($rent_status == self::AVAILABLE) {
            $this ->increment('rent_count', 1);
            $this -> status = self::LOANEDOUT;
            $this -> rent_user_id = $rent_user_id;
            $this -> save();
        } else {
            return false;
        }
    }


    public function returnBook($back_status)
    {
        if ($back_status == self::LOANEDOUT) {
            $this -> status = self::AVAILABLE;
            $this -> rent_user_id = null;
            $this ->save();
        } else {
            return false;
        }
    }
}
