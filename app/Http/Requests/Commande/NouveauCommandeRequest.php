<?php

namespace App\Http\Requests\Commande;

use Illuminate\Support\Facades\Gate;
use App\Traits\Commande\WithValidation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


/**
 * @bodyParam   login    string  required    Username or email adress of the user.      Exemple: testuser@example.com, user123
 * @bodyParam   password    string  required    The password of the  user.   Example: secret
 */
class NouveauCommandeRequest extends FormRequest
{
    use WithValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return Gate::allows('add_commande');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->validationRules();
    }

    /**
     * Message de validation
     *
     * @return array
     */
    public function messages()
    {
        return $this->ValidationMessages();
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


    public function prepareForValidation()
    {
        /*if ($this->numero === null and $this->type === 1) {
            $numeroDevis = numeroDevis($this->boolean('appro'));
            $this->merge([
                'numero' => $numeroDevis,
            ]);
        }*/

        $this->toogleClientFrs();

        if ($this->date !== null) {
            $date = Carbon::parse($this->date)->setTimezone('EAT');
            $this->merge([
                'date' => $date->toDateTimeString(),
            ]);
        }
    }
}
