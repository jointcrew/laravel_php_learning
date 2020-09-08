<?php

namespace App\Exports;

use App\UserInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserInfoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserInfo::all();
    }
}
