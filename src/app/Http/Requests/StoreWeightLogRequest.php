<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightLogRequest extends FormRequest
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
            'date' => 'required|date',
            'weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,3}(\.\d)?$/',
            ],
            'calories' => 'required|numeric',
            'exercise_time' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'exercise_content' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.regex' => '4桁までの数字で入力してください（小数点は1桁）',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.numeric' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_time.regex' => '運動時間は「00:30」の形式で入力してください',
            'exercise_content.required' => '運動内容を入力して下さい',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }

}
