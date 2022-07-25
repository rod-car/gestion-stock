<?php

namespace App\Http\Requests\Parametres;

use App\Rules\NIF;
use App\Rules\STAT;
use Illuminate\Foundation\Http\FormRequest;

class ParametresGeneraleRequest extends FormRequest
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
            "nom" => ["required", "sometimes", "min:5", "max:255"],
            "contact" => ["required", "sometimes", "min:10", "max:25"],
            "email" => ["required", "email"],
            "assujeti" => ["required", "boolean"],
            "nif" => ["nullable", new NIF],
            "stat" => ["nullable", new STAT],
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => "Le nom de l'entreprise est obligatoire",
            "nom.min" => "Le nom de l'entreprise doit êtrea au moins :min caractères",
            "nom.max" => "Le nom de l'entreprise ne doit pas depasser :max caractères",

            "contact.required" => "Lecontact est obligatoire",
            "contact.min" => "Le contact de l'entreprise doit êtrea au moins :min caractères",
            "contact.max" => "Le contact de l'entreprise ne doit pas depasser :max caractères",

            "email.required" => "L'adresse email est obligatoire",
            "email.email" => "Le format de l'email est invalide",

            "assujeti.required" => "L'état du TVA est obligatoire",
        ];
    }
}
