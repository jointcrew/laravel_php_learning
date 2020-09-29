<?php

namespace App\Exports;

use App\Models\UserInfo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UserInfoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{


    private $template_file = null;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserInfo::select('id', 'last_name', 'name', 'last_name_kana', 'name_kana', 'gender', 'status', 'birthday_day')->get();
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

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // 書き込み直前イベントハンドラ
            BeforeWriting::class => function (BeforeWriting $event) {
                //$sheet = $event->writer->getSheetByIndex(0)->getDelegate();
                //罫線設定
                $sheet = new Style();

                $sheet->applyFromArray([
                 'borders' => [
                   'bottom' => ['borderStyle' => Border::BORDER_THIN],
                   'right'  => ['borderStyle' => Border::BORDER_THIN],
                   'top'    => ['borderStyle' => Border::BORDER_THIN],
                   'left'   => ['borderStyle' => Border::BORDER_THIN],
                  ]
                ]);
                // セルの範囲を指定して罫線を反映
                $sheet->getActiveSheet()->duplicateStyle($sharedStyle, "A1:H$count");
                // 外枠
                $event->writer->getSheetByIndex(0)->getDelegate()->sheet->getActiveSheet()->duplicateStyle($sharedStyle, "A1:H$count");
            },
        ];
    }
}
