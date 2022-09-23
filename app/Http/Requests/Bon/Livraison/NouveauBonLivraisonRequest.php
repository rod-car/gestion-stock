<?php

namespace App\Http\Requests\Bon\Livraison;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Bon\Livraison\WithValidation;
use Illuminate\Contracts\Validation\Validator;

class NouveauBonLivraisonRequest extends FormRequest
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
        if ($this->numero === null) {
            $numeroBonReception = numeroBonReception();
            $this->merge([
                'numero' => $numeroBonReception,
            ]);
        }

        if ($this->date !== null) {
            $date = Carbon::parse($this->date)->setTimezone('EAT');
            $this->merge([
                'date' => $date->toDateString(),
            ]);
        }

        if (intval($this->a_la_charge_de) !== 0 AND doubleval($this->cout) === doubleval(0))
        {
            $this->merge([
                "cout" => null
            ]);
        }
    }
}
