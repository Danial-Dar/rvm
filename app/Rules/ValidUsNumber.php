<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUsNumber implements Rule
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
        $formated=formatNumber($value);
        // $formated=validateNumber($value);
        return !!maskUsNumber($formated);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be Valid Us Phone number.';
    }
}
