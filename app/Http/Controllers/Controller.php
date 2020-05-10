<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const RESPONSE_CODE_200 = '200';
    const RESPONSE_CODE_400 = '400';
    const RESPONSE_CODE_401 = '401';
    const RESPONSE_CODE_402 = '402';
    const RESPONSE_CODE_403 = '403';
    const RESPONSE_CODE_404 = '404';
    const RESPONSE_CODE_405 = '405';
    const RESPONSE_CODE_406 = '406';
    const RESPONSE_CODE_407 = '407';
    const RESPONSE_CODE_408 = '408';
    const RESPONSE_CODE_409 = '409';
}
