<?php

namespace App\Http\Requests\Depot;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class NouveauDepotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('add_point_vente');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nom" => ["required", "unique:depots,nom", "min:2", "max:255"],
            "localisation" => ["required", "sometimes", "min:5", "max:255"],
            "contact" => ["nullable", "sometimes", "min:10", "max:255"],
            "point_vente" => ["required", "boolean"],
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => "Le nom est obligatoire",
            "localisation.required" => "La localisation est réquis",
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
