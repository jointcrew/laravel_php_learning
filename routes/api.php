<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('apiuser', 'Api\ApiUserController');

Route::apiResource('api_itemuser', 'Api\ApiItemUserController');

Route::apiResource('api_goodsuser', 'Api\ApiGoodsUserController');

Route::resource('books', 'Api\BookController');
