<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValiDemoRequest extends FormRequest
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
            'email' => 'required|email',
            'pass' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attributeは必須です',
            'email.email' => ':attributeの形式でご入力ください',
            'pass.required' => ':attributeは必須です'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'pass' => 'パスワード'
        ];

    }

}
