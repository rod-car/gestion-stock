<?php

namespace App\Http\Requests\Facturation;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NouvelleFactureRequest extends FormRequest
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
            "numero_facture" => ["required", "sometimes", "unique:factures,numero_facture"],
            "commande" => ["required", "exists:commandes,id"],
            "echeance" => ["required", "numeric", "min:1", "max:365"],
            "taux_penalite" => ["nullable", "numeric", "min:10", "max:999999999999.99"],
            "date_facturation" => ["required", "date", "date_format:Y-m-d", "before_or_equal:" . today()->toDateString()],
            "date_vente" => ["required", "date", "date_format:Y-m-d", "before_or_equal:" . today()->toDateString()],
        ];
    }


    /**
     * Traiter les données avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->date_facturation !== null) {
            $date = Carbon::parse($this->date)->setTimezone('EAT');
            $this->merge([
                'date_facturation' => $date->toDateString(),
            ]);
        }
    }
}
