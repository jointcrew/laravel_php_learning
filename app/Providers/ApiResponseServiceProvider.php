<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * response macro
     *
     * @return void
     */
    public function boot()
    {
        // success
        Response::macro('success', function ($data = [], $status = null) {
            if (empty($status)) {
                $status = http_response_code();
            }
            return response()->json([
                'success'  => 'OK',
                'status'   => $status,
                'response' => $data
            ],
            $status,
            [],
            JSON_UNESCAPED_UNICODE);
        });

        // delete_success
        Response::macro('delete_success', function ($status = null) {
            if (empty($status)) {
                $status = http_response_code();
            }
            return response()->json([
                'status'   => $status,
            ],
            $status,
            [],
            JSON_UNESCAPED_UNICODE);
        });

        // error（画面側でエラー処理させる）
        //($errMsg = '', array $errors = [], $status = null)はデフォルト値、値があったら代入される
        Response::macro('error', function ($errMsg = '', array $errors = [], $status = null) {
            if (empty($status)) {
                $status = http_response_code();
            }
            $res = response()->json([
                'success' => 'error',
                'status'  => $status,
                'errMsg'  => $errMsg,
                'errors'  => $errors
            ],
            $status,
            [],
            JSON_UNESCAPED_UNICODE);
            //return と同じように返す役割を持つ
            throw new HttpResponseException($res);
        });

        // error
        // Response::macro('fatalError', function ($errMsg, array $errors = [], $status = ResponseStatus::HTTP_INTERNAL_SERVER_ERROR) {
        //     return response()->json([
        //         'success'       => 'error',
        //         'response_code' => $status,
        //         'errMsg'        => $errMsg,
        //         'errors'        => $errors
        //     ], $status);
        // });
    }
}
