<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;



class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name'         =>  'required|string|max:30',
            'age'               =>  'required|integer|max:150',
            'create_user_id'    =>  'required|integer|max:10',
            'create_user_name'  =>  'required|string|max:30',
        ];
    }

    protected function failedValidation(Validator $validator) {
        //ステータスを指定
        $status=Controller::RESPONSE_CODE_400;
        $res = response()->json([
            'success' => 'error',
            'status'  => Controller::RESPONSE_CODE_400,
            'errors'  => $validator->errors(),
        ],
        $status,
        [],
        //JSON_UNESCAPED_UNICODEを入れると日本語になる
        JSON_UNESCAPED_UNICODE);
        throw new HttpResponseException($res);
    }
}
