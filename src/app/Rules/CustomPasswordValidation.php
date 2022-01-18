<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordValidation implements Rule
{
    //最小文字数
    private const MIN_CHARACTER = 8;
    //最大文字数
    private const MAX_CHARACTER = null;
    //1文字以上の半角英字（大文字）
    private const INCLUDE_LESS_THAN_ONE_UPPER_LETTER = true;
    //1文字以上の半角英字（小文字）
    private const INCLUDE_LESS_THAN_ONE_LOWER_LETTER = true;
    //1文字以上の半角数字
    private const INCLUDE_LESS_THAN_ONE_NUMBER = true;


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regexOfValidation = "[a-zA-z\d]";
        // 半角英字（小文字）1文字以上
        if (self::INCLUDE_LESS_THAN_ONE_LOWER_LETTER) {
            $regexOfValidation = "(?=.*?[a-z])" . $regexOfValidation;
        }
        // 半角英字（大文字）1文字以上
        if (self::INCLUDE_LESS_THAN_ONE_UPPER_LETTER) {
            $regexOfValidation = "(?=.*?[A-Z])" . $regexOfValidation;
        }
        // 半角数字1文字以上
        if (self::INCLUDE_LESS_THAN_ONE_NUMBER) {
            $regexOfValidation = "(?=.*?\d)" . $regexOfValidation;
        }
        // 最大、最小文字数
        if (self::MAX_CHARACTER || self::MIN_CHARACTER) {
            $regexOfValidation = $regexOfValidation . "{" . self::MIN_CHARACTER . "," . self::MAX_CHARACTER . "}";
        }
        $regexOfValidation = "/\A{$regexOfValidation}+\z/";

        return preg_match($regexOfValidation, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $validationMessage = 'パスワードは';
        $validationOneLetterMessage = [];
        if (self::INCLUDE_LESS_THAN_ONE_LOWER_LETTER) {
            $validationOneLetterMessage[] = '半角英字（小文字）';
        }
        if (self::INCLUDE_LESS_THAN_ONE_UPPER_LETTER) {
            $validationOneLetterMessage[] = '半角英字（大文字）';
        }
        if (self::INCLUDE_LESS_THAN_ONE_NUMBER) {
            $validationOneLetterMessage[] = '半角数字';
        }
        if ($validationOneLetterMessage) {
            $validationMessage .= implode('、', $validationOneLetterMessage) . 'を１文字以上含む';
        }
        if (self::MIN_CHARACTER) {
            $validationMessage .= self::MIN_CHARACTER . "文字以上";
        }
        if (self::MAX_CHARACTER) {
            $validationMessage .= self::MAX_CHARACTER . "文字以下";
        }
        $validationMessage .= 'で入力してください';

        return $validationMessage;
    }
}
