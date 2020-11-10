<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnglishAlphabet implements Rule
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
        return (bool) preg_match("/^([()a-zA-Z\-_0-9:;\s]*)*$/u", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute به درستی وارد نشده است؛ تنها حروف و اعداد انگلیسی، علائم نگارشی برخی علائم دیگر مانند - _ \' " مجاز هستند ';
    }
}
