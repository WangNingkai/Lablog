<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateName implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = '/^[a-zA-Z0-9_]{8,15}$/';
        return preg_match($pattern,$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '用户名必须是字母、数字、下划线组合，且长度是8-15字符';
    }
}
