<?php

namespace App\Exports;

use App\Models\UserInfo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;


class UserInfoExport implements FromCollection, WithHeadings,ShouldAutoSize, WithTitle
{


    private $template_file = null;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserInfo::select('id','last_name','name','last_name_kana','name_kana','gender','status','birthday_day')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'last_name',
            'name',
            'last_name_kana',
            'name_kana',
            'gender',
            'status',
            'birthday_day'
        ];
    }

    public function title(): string
    {
        return 'user_info';
    }

}
