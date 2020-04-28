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

//サンプルページ 追加
Route::get('/sample', 'SampleController@index')->name('sample');
Route::post('/sample', 'SampleController@index')->name('sample');

//サンプルページ 一覧
Route::get('/sampleList', 'SampleController@sampleList')->name('sampleList');
Route::post('/sampleList', 'SampleController@sampleList')->name('sampleList');

//itemページ 追加
Route::get('/items', 'ItemController@index')->name('items');
Route::post('/items', 'ItemController@index')->name('items');

//itemページ　一覧
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
