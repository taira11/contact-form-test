<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'last_name' => 'required|string|max:8',
            'first_name' => 'required|string|max:8',
            'gender' => 'required',
            'email' => 'required|email',
            'tel.*' => 'required|numeric|digits_between:1,5',
            'address' => 'required|string',
            'category_id' => 'required',
            'detail' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => '姓は必須です。',
            'last_name.max' => '姓は8文字以内で入力してください。',
            'first_name.required' => '名は必須です。',
            'first_name.max' => '名は8文字以内で入力してください。',
            'gender.required' => '性別を選択してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'tel.*.required' => '電話番号は必須です。',
            'tel.*.numeric' => '電話番号は半角数字で入力してください。',
            'tel.*.digits_between' => '電話番号は5桁以内で入力してください。',
            'address.required' => '住所は必須です。',
            'category_id.required' => 'お問い合わせの種類を選択してください。',
            'detail.required' => 'お問い合わせ内容は必須です。',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください。',
        ];
    }
};
