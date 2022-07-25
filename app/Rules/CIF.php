<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CIF implements Rule
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
        return preg_match("/^([A-Wa-w])([0-9]{7})([0-9A-Ja-j])$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Le format de la CIF n'est pas valide";
    }
}
