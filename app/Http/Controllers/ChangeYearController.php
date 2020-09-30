<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeYearController extends Controller
{
    /**
     * 和暦を西暦に変換
     * @param Request $request
     * @return view
     */
    public function changeYear(Request $request)
    {
        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post') == true) {
            $year = $request->input('year');
            $eras = [
                ['year' => 2018, 'name' => '令和'],
                ['year' => 1988, 'name' => '平成'],
                ['year' => 1925, 'name' => '昭和'],
                ['year' => 1911, 'name' => '大正'],
                ['year' => 1867, 'name' => '明治']
            ];
            foreach ($eras as $era) {
                $base_year = $era['year'];
                $era_name = $era['name'];
                if ($year > $base_year) {
                    $era_year = $year - $base_year;
                    if ($era_year === 1) {
                        return view('changeYear', compact('era_name'));
                    }
                    return view('changeYear', compact('era_name', 'era_year'));
                }
            }
        }
        return view('changeYear');
    }
}
