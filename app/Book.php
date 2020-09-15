<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public const Available = 1;
    public const LoanedOut = 2;

    public function checkOut() {
        $this->increment('rent_count', 1);
        $this->status = self::LoanedOut;
        $this->save();
    }

    public function returnBook() {
        $this->status = self::Available;
        $this->save();
    }
}
