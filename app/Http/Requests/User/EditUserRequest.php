<?php

namespace App\Http\Requests\User;

use App\Rules\Name;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditUserRequest extends FormRequest
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
            'nom_personnel' => ["required", new Name, "min:2", "max:255"],
            'prenoms_personnel' => ["nullable", new Name, "min:2", "max:255"],
            'contact_personnel' => ["required", "phone:AUTO"],
            'email' => ["nullable", "unique:users,email," . $this->id . ",id", "email", "max:255"],
            'adresse_personnel' => ["required", "sometimes"],
            'cin_personnel' => ["nullable", "digits:12"],

            'username' => ["nullable", "required_if:hasAccount,true", "unique:users,username," . $this->id . ",id", "min:5", "max:255"],
            'password' => ["nullable", "required_if:hasAccount,true", "confirmed", "min:8", "max:255"],
            'password_confirmation' => ["nullable", "required_if:hasAccount,true", "min:8", "max:255"],

            'roles' => ["nullable", "array"],
            'roles.*' => ["nullable", "exists:roles,id"],

            'fonctions' => ["required", "array"],
            'fonctions.*' => ["required", "exists:fonctions,id"]
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

            'contact_personnel.required' => "Le contact du personnel est obligatoire",
            'contact_personnel.phone' => "Le format de contact du personnel est invalide",

            'email.email' => "Le format de l'email n'est pas valide (email@example.com)",
            'email.unique' => "Cet adresse email est déja utilisé par d'autre personnel",
            'email.max' => "L'adresse email ne doit pas depasser :max caractère(s)",

            'adresse_personnel.required' => "L'adresse du personnel est réquis",

            'cin_personnel.digits' => "Le CIN doit être un chiffre et exactement :digits chiffre(s)",

            'username.required_if' => "Le nom d'utilisateur est réquis si le personnel possède un compte utilisateur",
            'username.unique' => "Le nom d'utilisateur est déja pris",
            'username.min' => "Le nom d'utilisateur doit être au moins :min caractère(s)",
            'username.max' => "Le nom d'utilisateur ne doit pas depasser :max caractère(s)",

            'password.required_if' => "Le mot de passe est réquis si le personnel possède un compte utilisateur",
            'password.confirmed' => "Les deux mot de passe ne correspond",
            'password.min' => "Le mot de passe doit être au moins :min caractère(s)",
            'password.max' => "Le mot de passe ne doit pas depasser :max caractère(s)",

            'password_confirmation.required_if' => "La confirmation de mot de passe est réquis si le personnel possède un compte utilisateur",
            'password_confirmation.min' => "La confirmation de mot de passe doit être au moins :min caractère(s)",
            'password_confirmation.max' => "La confirmation de mot de passe ne doit pas depasser :max caractère(s)",
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
