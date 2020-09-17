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

    public const Available = 1;
    public const LoanedOut = 2;

    public function checkOut($rent_status,$rent_user_id) {
        if ($rent_status == self::Available ) {
            $this ->increment('rent_count', 1);
            $this -> status = self::LoanedOut;
            $this -> rent_user_id = $rent_user_id;
            $this -> save();
        } else {
            return false;
        }
    }


    public function returnBook($back_status) {
        if ($back_status == self::LoanedOut ) {
            $this -> status = self::Available;
            $this -> rent_user_id = null;
            $this ->save();
        } else {
            return false;
        }
    }

}
