<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sample;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class SampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * サンプルトップ画面
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        // 現在認証されているユーザーの取得
        $user = Auth::user();
        // 現在認証されているユーザーのID取得
        $id = Auth::id();

        //Sampleモデルに記載している、種別を取得
        $type_array = Sample::$type;

        //保存ボタンを押したときに処理をする
        if ($request->isMethod('post')) {
            //フォームの内容をすべて取得(一部取りたいときは$request->sample_name()のようにフィールド名を指定)
            $data = $request->all();
            //配列にcreate_userを追加
            $data['create_user'] = $id;
            //Sampleモデルのinsertメソッドにアクセスし、データを保存
            Sample::insert($data);
        }

        return view('sample', compact('type_array'));
    }

    /**
     * サンプル一覧画面
     * @param Request $request
     * @return view
     */
    public function sampleList(Request $request)
    {
        //Sampleモデルから全件データを取得する。
        $list = Sample::all();

        return view('sampleList', compact('list'));
    }

    /**
     * サンプルAPI(rest apiを実行)
     * @return json
     */
    public function sampleApi()
    {
        //他からRESTAPIを呼び出すときは、use GuzzleHttp\Client;を宣言する。
        try {
            //http通信を行う
            $client = new Client();
            $response = $client->request("GET", \Config::get('services.api_url.restapi'));
            //getBody()でAPIの結果を取得
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            //アクセス失敗したらエラーを返す
            return $e->getHandlerContext()['error'];
        }
    }
}
