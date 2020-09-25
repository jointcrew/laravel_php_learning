<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\User;
use Session;

class UnitTestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Unitテスト画面表示
     *
     * @return view
     */
    public function book_manage()
    {
        //APIをつかって取得
        try {
            //http通信を行う
            $client = new Client();
            $url = \Config::get('services.book_api_url.restapi');
            $response = $client->request("GET", $url );
            //getBody()でAPIの結果を取得
            $datalist = $response->getBody();
            //json_decodeで配列型に変換
            $datalist = json_decode($datalist, true);
            //$datalist["response"]だけ取り出す
            $datalist = $datalist["response"];

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }
        return view('bookManage',compact('datalist'));
    }

    /**
     * 本登録
     * @param Request $request
     * @return view
     */
    public function book_register(Request $request)
    {
        $data = $request->validate([
           'title'             =>'required|string|max:50',
           'author'            =>'required|string|max:50',
           'description'       =>'required|string|max:500',
        ]);
        //APIをつかって取得
        try {
            //http通信を行う
            $client = new Client();
            $url = \Config::get('services.book_api_url.restapi');
            $option = [
                'form_params' =>
                [
                    'title'               => $data['title'],
                    'author'              => $data['author'],
                    'description'         => $data['description'],
                ]
            ];
            $response = $client->request("POST", $url, $option );
            //getBody()でAPIの結果を取得
            $insert_list = $response->getBody();
            //json_decodeで配列型に変換
            $insert_list = json_decode($insert_list, true);

            //文言を$msgに代入
            if ($insert_list == null) {
               $msg= \Lang::get('user.user_register_fail');
            } else {
               $msg =\Lang::get('user.user_register_success');
            }

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }
        return view('bookManage',compact('insert_list','msg'));
    }

    /**
     * 本貸し出し
     * @param Request $request
     * @return view
     */
    public function book_rent(Request $request)
    {
        $data = $request->validate([
           'rent_book_id'             =>"required|integer|exists:books,id",
           'rent_user_id'             =>"required|integer|exists:users,id",
        ]);

        //利用本数を記録、本は3冊まで。3冊以上借りようとしたら、リダイレクトエラー
        $check = User::where('id',$data['rent_user_id'])->first();
        $number_book_rent = $check->checkRentBookNumber();
        //貸出冊数上限越えなら、リダイレクト
        if ($number_book_rent === false) {
            return back()->with('message', '貸出上限を超えています');
        }

        $book = Book::find($data['rent_book_id']);
        //statusを取得
        $status = $book->status;
        //貸出、statusを貸出不可に変更,利用者登録
        $result = $book->checkOut($status,$data['rent_user_id']);
        //貸出不可なら、リダイレクト
        if ($result === false) {
            return back()->with('message', '貸出不可');
        }
        if (is_null($result)) {
            $msg = \Lang::get('unit_test.rent_ok');
        }
        //一覧表示
        try {
            //http通信を行う
            $client = new Client();
            $url = \Config::get('services.book_api_url.restapi');
            $response = $client->request("GET", $url );
            //getBody()でAPIの結果を取得
            $datalist = $response->getBody();
            //json_decodeで配列型に変換
            $datalist = json_decode($datalist, true);
            //$datalist["response"]だけ取り出す
            $datalist = $datalist["response"];

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }

        return view('bookManage',compact('datalist','msg'));
    }

    /**
     * 本返却
     * @param Request $request
     * @return view
     */
    public function book_return(Request $request)
    {
        $data = $request->validate([
           'return_book_id'             =>'required|integer|exists:books,id',
        ]);

        $book = Book::find($data['return_book_id']);
        //statusを取得
        $status = $book->status;
        //userを取得
        $user = $book->rent_user_id;
        //貸出可能にstatusを変更
        $result = $book->returnBook($status);

        if ($result === false) {
            return back()->with('message', '返却済み');
        }
        if (is_null($result)) {
            $msg = \Lang::get('unit_test.return_ok');
        }
        //利用本数を-1
        $check = User::where('id',$user)->first();
        $return = $check->checkReturnBookNumber();
        //返却の際、貸出冊数が0~3以外の本数だった場合
        if ($return === false) {
            return back()->with('message', '返却エラー');
        }
        //一覧表示
        try {
            //http通信を行う
            $client = new Client();
            $url = \Config::get('services.book_api_url.restapi');
            $response = $client->request("GET", $url );
            //getBody()でAPIの結果を取得
            $datalist = $response->getBody();
            //json_decodeで配列型に変換
            $datalist = json_decode($datalist, true);
            //$datalist["response"]だけ取り出す
            $datalist = $datalist["response"];

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }
        return view('bookManage',compact('datalist','msg'));
    }
}
