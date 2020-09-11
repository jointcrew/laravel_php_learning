<?php

namespace App\Http\Controllers;

require_once "../vendor/autoload.php";

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Exports\UserInfoExport;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell;
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class ExcelController extends Controller
{
    /**
     * excelデータ出力画面
     * @param Request $request
     * @return view
     */
    public function excel()
    {
        //現在認証されているユーザーの全商品を取得
        $userlist = UserInfo::paginate(15);
        return view('excel',compact('userlist'));
    }

    /**
     * excelデータ出力
     * @param Request $request
     * @return view
     */
    public function export()
    {
        // Excel 定義
        //return Excel::download(new UserInfoExport, 'users.xlsx');
        $spreadsheet = new Spreadsheet();
        // スプレッドシート作成
        $sheet_name = 'users';
        $spreadsheet->getActiveSheet()->setTitle($sheet_name, false);

        $UserInfo = new UserInfo();
        //DBのtittle取得
        $tittle = $UserInfo->fillable;
        //DBのuser情報取得
        $datas = $UserInfo->all();
        //excelへの挿入データ
        $export_data = [
          [
              $tittle['id'],
              $tittle['last_name'],
              $tittle['name'],
              $tittle['last_name_kana'],
              $tittle['name_kana'],
              $tittle['gender'],
              $tittle['status'],
              $tittle['birthday_day']
          ],
        ];
        //枠線範囲指定のため、データ数を数える
        $count = 1;
        foreach ($datas as $data) {
            $push_data = [
                $data['id'],
                $data['last_name'],
                $data['name'],
                $data['last_name_kana'],
                $data['name_kana'],
                $data['gender'],
                $data['status'],
                $data['birthday_day']
            ];
            //挿入データを追加
            array_push($export_data,$push_data);
            $count++;
        }
        //A1から情報挿入
        $start_cell = 'A1';
        $spreadsheet->getActiveSheet()->fromArray($export_data, NULL, $start_cell, true);
        //罫線設定
        $sharedStyle = new Style();
        $sharedStyle->applyFromArray([
         'borders' => [
           'bottom' => ['borderStyle' => Border::BORDER_THIN],
           'right'  => ['borderStyle' => Border::BORDER_THIN],
           'top'    => ['borderStyle' => Border::BORDER_THIN],
           'left'   => ['borderStyle' => Border::BORDER_THIN],
          ]
        ]);
        // セルの範囲を指定して罫線を反映
        $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle, "A1:H$count");
        //タイトルがあるセル幅設定
        $tittle_count = count($export_data[0]);
        $tittle_count--;
        $alphas = range('A', 'Z');
        foreach ($alphas as $key => $alpha) {
            $spreadsheet->getSheet(0)->getColumnDimension( $alpha )->setWidth( 15.25 );
            if ($key == $tittle_count) {
                break;
            }
        }
        //作成したexcelを保存
        $file_path = '/var/www/html/phptest/';
        $file_name = 'users_info.xlsx';
        $writer = new Xlsx($spreadsheet);
        $check = $writer->save($file_path.$file_name);

        if ($check == false) {
            $msg = \Lang::get('excel.export_success');
        } else {
            $msg = \Lang::get('goods.export_fail');
        }

        //excelデータ出力画面へ
        $userlist = UserInfo::paginate(15);
        return view('excel',compact('userlist','msg'));
    }
}
