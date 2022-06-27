<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditFonctionRequest extends FormRequest
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
            'nom_fonction' => ["required", "sometimes", "min:2", "max:255"],
            'description_fonction' => ["nullable", "sometimes", "min:5", "max:5000"],

            'enfants' => ["nullable", "array"],
            'permissions' => ["nullable", "array"],

            /*'permissions' => ["nullable", "array"],
            'permissions.*' => ["nullable", "exists:roles,id"]*/
        ];
    }


    /**
     * Messages d'erreus
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nom_fonction.required' => "Le nom de la fonction est réquis",
            'nom_fonction.min' => "Le nom de la fonction doit être au moins :min caractère(s)",
            'nom_fonction.max' => "Le nom de la fonction ne doit pas depasser :max caractère(s)",

            'description_fonction.min' => "Le description doit être au moins :min caractère(s)",
            'description_fonction.max' => "Le description ne doit pas depasser :max caractère(s)",
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
            throw new HttpResponseException(response()->json([
                "errors" => $validator->errors(),
                "message" => $message
            ], 422));
        }
        return back()->withErrors($validator)->withInput();
    }
}
