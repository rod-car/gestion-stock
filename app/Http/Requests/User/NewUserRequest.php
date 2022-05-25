<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewUserRequest extends FormRequest
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
            'nom_personnel' => ["required", "min:2", "max:255"],
            'prenoms_personnel' => ["nullable", "min:2", "max:255"],
            'contact_personnel' => ["required", "sometimes"],
            'email' => ["nullable", "unique:users,email", "email", "max:255"],
            'adresse_personnel' => ["required", "sometimes"],
            'cin_personnel' => ["nullable", "digits:12"],
            'username' => ["nullable", "required_if:hasAccount,true", "unique:users,username", "min:5", "max:255"],
            'password' => ["nullable", "required_if:hasAccount,true", "confirmed", "min:8", "max:255"],
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
            'nom_personnel.required' => "Le nom du personnel est réquis",
            'nom_personnel.min' => "Le nom du personnel doit être au moins :min caractère(s)",
            'nom_personnel.max' => "Le nom du personnel ne doit pas depasser :max caractère(s)",

            'prenoms_personnel.min' => "Le prénoms du personnel doit être au moins :min caractère(s)",
            'prenoms_personnel.max' => "Le prénoms du personnel ne doit pas depasser :max caractère(s)",
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
