<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Exports\UserInfoExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $userlist = UserInfo::paginate(10);
        return view('excel',compact('userlist'));
    }

    public function export()
    {
        // 出力データ取得
        $users = UserInfo::all();

        // Excel 定義
        Excel::create('Sample', function($excel) {

        })->export("xlsx");
    }
}
