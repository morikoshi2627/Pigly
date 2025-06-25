<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitialWeightRequest extends FormRequest
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
            'weight' => 'required|numeric|regex:/^\d{1,3}(\.\d)?$/',// 最大999.9まで、小数1桁
            'target_weight' => 'required|numeric|regex:/^\d{1,3}(\.\d)?$/',
        ];
    }

    public function messages()
    {
        return [
            'weight.required' => '現在の体重を入力してください',
            'weight.numeric' => '体重は数値で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',

            'target_weight.required' => '目標体重を入力してください',
            'target_weight.numeric' => '目標体重は数値で入力してください',
            'target_weight.regex' => '小数点は1桁で入力してください',
        ];
    }
}
