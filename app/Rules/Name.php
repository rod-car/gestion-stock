<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


/**
 * Classe qui permet de valider un nom ou des prénoms
 */
class Name implements Rule
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
        return preg_match("/^([a-zA-Z' ]+)$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La valeur du champ n\'est pas valide.';
    }
}
