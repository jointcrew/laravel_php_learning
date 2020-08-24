<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hello', 'HelloController@index')->name('hello');

//Route::get('/itemAdd', 'ItemAddController@index')->name('itemAdd');

//ログイン状態の一般ユーザ（全ユーザー）がアクセス可能
Route::group(['middleware' => ['auth', 'can:user']], function () {
  //サンプルページ 追加
  Route::get('/sample', 'SampleController@index')->name('sample');
  Route::post('/sample', 'SampleController@index')->name('sample');

  //サンプルページ 一覧
  Route::get('/sampleList', 'SampleController@sampleList')->name('sampleList');
  Route::post('/sampleList', 'SampleController@sampleList')->name('sampleList');

  //サンプルAPIアクセス
  Route::get('/sampleApi', 'SampleController@sampleApi')->name('sampleApi');

  //itemページ 追加
  Route::get('/items', 'ItemController@index')->name('items');
  Route::post('/items', 'ItemController@index')->name('items');

  //itemページ一覧
  Route::get('/itemList', 'ItemController@itemList')->name('itemList');
  Route::post('/itemList', 'ItemController@itemList')->name('itemList');

  //検索ページ
  Route::get('/itemsearch', 'ItemController@itemsearch')->name('itemsearch');
  Route::post('/itemsearch', 'ItemController@itemsearch')->name('itemsearch');

  //商品削除
  Route::get('/itemDelete', 'ItemController@itemDelete')->name('itemDelete');
  //商品編集
  Route::get('/itemEdit', 'ItemController@itemEdit')->name('itemEdit');
  Route::post('/itemEdit', 'ItemController@itemEdit')->name('itemEdit');

  //API一覧画面
  Route::get('/apiList', 'ApiListController@index')->name('apiList');
});

// ログイン状態の管理者がアクセス可能
Route::group(['middleware' => ['auth', 'can:admin']], function () {
  //User一覧
  Route::get('/userList', 'ItemController@userList')->name('userList');
  Route::post('/userList', 'ItemController@userList')->name('userList');
  //登録者削除
  Route::get('/userDelete', 'ItemController@userDelete')->name('userDelete');
  //登録者編集
  Route::get('/userEdit', 'ItemController@userEdit')->name('userEdit');
  Route::post('/userEdit', 'ItemController@userEdit')->name('userEdit');

  //API一覧画面
  Route::get('/apiList', 'ApiListController@index')->name('apiList');
  //APIユーザー検索
  Route::get('/userApiSearch', 'ItemController@userApiSearch')->name('userApiSearch');
  //APIユーザー登録
  Route::get('/userApiRegister', 'ItemController@userApiRegister')->name('userApiRegister');
  Route::post('/userApiRegister', 'ItemController@userApiRegister')->name('userApiRegister');
});
//自力で作ろう
//検索画面
Route::get('/goodsSearch', 'GoodsController@goodsSearch')->name('goodsSearch');
Route::post('/goodsSearch', 'GoodsController@goodsSearch')->name('goodsSearch');
//決済前確認画面
Route::post('/beforeSettle', 'GoodsController@beforeSettle')->name('beforeSettle');
//決済処理
Route::get('/goodsSettle', 'GoodsController@goodsSettle')->name('goodsSettle');
Route::post('/goodsSettle', 'GoodsController@goodsSettle')->name('goodsSettle');
//商品登録・編集
Route::get('/goodsEdit', 'GoodsController@goodsEdit')->name('goodsEdit');
Route::post('/goodsEdit', 'GoodsController@goodsEdit')->name('goodsEdit');
//商品詳細
Route::get('/goodsDetail', 'GoodsController@goodsDetail')->name('goodsDetail');
//ユーザー管理
Route::get('/goodsUser', 'GoodsController@goodsUser')->name('goodsUser');
//ユーザー登録・編集
Route::get('/goodsUserEdit', 'GoodsController@goodsUserEdit')->name('goodsUserEdit');
Route::post('/goodsUserEdit', 'GoodsController@goodsUserEdit')->name('goodsUserEdit');


Route::post('user/{id}', ['as'=>'user.update', 'uses'=>'UserController@updateUserProfile']);
