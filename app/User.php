<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 利用冊数を+1、３冊までしか借りられない
     *@param int  $data
     *@return false
     *
     */
    public function checkRentBookNumber()
    {
        //rent_booksを取得
        $rent_books = $this->rent_books;
        //貸出冊数が0~2冊までだったら、現冊数に+1
        if ((0 <= $rent_books) && ($rent_books < 3)) {
            $this->increment('rent_books', 1);
        } else {
            return false;
        }
        $this->save();
    }

    /**
     * 利用冊数を-1
     *@param int  $data
     *
     */
    public function checkReturnBookNumber()
    {
        //rent_booksを取得
        $rent_books = $this->rent_books;
        //貸出冊数が1~３冊までだったら、現冊数に-1
        if ((0 < $rent_books) && ($rent_books <= 3)) {
            $this->decrement('rent_books', 1);
        } else {
            return false;
        }
        $this->save();
    }
}
