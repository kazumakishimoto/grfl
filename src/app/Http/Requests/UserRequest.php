<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        // ゲストユーザーログイン時に、ユーザー名とメールアドレスを変更できないよう対策
        if (Auth::id() == config('user.guest_user.id')) {
        return [
            'age' => ['numeric', 'min:1', 'max:100', 'nullable'],
            'avatar' => ['image', 'nullable'],
            // 'avatar'     => ['file', 'mimes:jpeg,png,jpg,bmb', 'max:2048'],
            'introduction' => ['max:200', 'nullable'],
            ];
        }

        return [
            'name' => ['required','regex:/^(?!.*\s).+$/u', 'regex:/^(?!.*\/).*$/u', 'max:15', Rule::unique('users')->ignore(Auth::id())],
            'age' => ['numeric', 'min:1', 'max:100', 'nullable'],
            'introduction' => ['max:200', 'nullable'],
            'avatar' => ['image', 'nullable'],
            // 'avatar'     => ['file', 'mimes:jpeg,png,jpg,bmb', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'age' => '年齢',
            'introduction' => '自己紹介',
            'avatar' => 'プロフィール画像',
            'email' => 'メールアドレス',
            // 'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => ':attributeに「/」と半角スペースは使用できません。'
        ];
    }
}
