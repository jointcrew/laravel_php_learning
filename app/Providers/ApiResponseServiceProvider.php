<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

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

        // error（画面側でエラー処理させる）
        Response::macro('error', function ($errMsg = '', array $errors = [], $status = null) {
            if (empty($status)) {
                $status = http_response_code();
            }
            return response()->json([
                'success' => 'error',
                'status'  => $status,
                'errMsg'  => $errMsg,
                'errors'  => $errors
            ],
            $status,
            [],
            JSON_UNESCAPED_UNICODE);
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
