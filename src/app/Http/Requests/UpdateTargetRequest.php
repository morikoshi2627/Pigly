<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTargetRequest extends FormRequest
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
            'target_weight' => 'required|numeric|regex:/^\d{1,3}(\.\d)?$/',// 最大999.9まで、小数1桁
        ];
    }

    public function messages(): array
    {
        return [
            'target_weight.required' => '目標体重を入力してください',
            'target_weight.numeric' => '目標体重は数値で入力してください',
            'target_weight.regex' => '4桁までの数字で入力してください（小数点は1桁）',
        ];
    }
}
