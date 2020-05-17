<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;

class PutRequest extends FormRequest
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
          'user_name' => 'string|nullable|max:30',
          'age'       => 'integer|nullable|max:150',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      $errors = $validator->errors();
      //ApiResponseServiceProviderでのエラーの定義を使う
      return response()->error(\Lang::get('api.api_e_title.t0004'), array($errors), Controller::RESPONSE_CODE_400);
    }
}
