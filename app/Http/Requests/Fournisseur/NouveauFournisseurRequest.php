<?php

namespace App\Http\Requests\Fournisseur;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class NouveauFournisseurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return Gate::allows('add_fournisseur');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nom" => ["required", "unique:fournisseurs,nom", "sometimes", "min:2", "max:255"],
            "adresse" => ["required", "sometimes", "min:5", "max:255"],
            "email" => ["nullable", "email", "max:255"],
            "contact" => ["required", "min:10", "max:30"],

            "categories" => ["nullable"],
            "categories.*" => ["nullable", Rule::exists("categories", "id")->where("type", 2)],

            "nif" => ["nullable", "regex:/^(0|1|2|3){1}\d{12}$/"],
            "cif" => ["nullable", "regex:/^([A-Wa-w])([0-9]{7})([0-9A-Ja-j])$/"],
            "stat" => ["nullable", "regex:/^\d{3}\s\d{3}\s\d{3}\s\d{5}$/"],
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => "Le nom du fournisseur est réquis",
            "nom.unique" => "Ce fournisseur existe déja",
            "nom.min" => "Le nom doit être au moins :min caractère",
            "nom.max" => "Le nom ne doit pas depasser :max caractère",

            "adresse.required" => "L'adresse est obligatoire",
            "adresse.min" => "L'adresse doit être au moins :min caractère(s)",
            "adresse.max" => "L'adresse ne doit pas depasser :max caractère(s)",

            "email.email" => "Veuillez choisir un adresse email valide (email@example.fr)",
            "email.min" => "L'adresse email doit être au moins :min caractère(s)",
            "email.max" => "L'adresse email ne doit pas depasser :max caractère(s)",

            "contact.required" => "Le contact est obligatoire",
            "contact.min" => "Le contact doit être au moins :min caractère(s)",
            "contact.max" => "Le contact ne doit pas depasser :max caractère(s)",

            "categories.*.exists" => "Veuillez selectionner les catégories dans la liste",

            "nif.regex" => "Le format du NIF est invalide",
            "cif.regex" => "Le format du CIF est invalide",
            "stat.regex" => "Le format du STAT est invalide",
        ];
    }

    /**
     * Si la validation échoue
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $message = "Les champs ne sont pas bien remplis";
        if (request()->ajax()) {
            return response()->json([
                "errors" => $validator->errors(),
                "message" => $message
            ], 422);
        }
        return back()->withErrors($validator)->withInput();
    }
}
