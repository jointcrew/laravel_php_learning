<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HeaderComposer
{
    public function compose(View $view)
    {
        /* 設定ファイルやDBの値を取得して、渡したいデータを生成する処理 */
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーのID取得
        $id = Auth::id();
        // 現在認証されているユーザーの権限を取得
        $role = $user["role"];
        $view->with('role', $role);
    }
}
