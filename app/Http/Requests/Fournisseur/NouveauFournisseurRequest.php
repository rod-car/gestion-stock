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

            "nif" => ["nullable"],
            "cif" => ["nullable"],
            "stat" => ["nullable"],

        ];
    }

    public function messages()
    {
        return [];
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
