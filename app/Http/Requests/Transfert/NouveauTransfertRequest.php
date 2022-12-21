<?php

namespace App\Http\Requests\Transfert;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Transfert\WithValidation;


class NouveauTransfertRequest extends FormRequest
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
     * Traitements avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->numero === null) {
            $numeroTransfert = numeroTransfert();
            $this->merge([
                'numero' => $numeroTransfert,
            ]);
        }

        if ($this->date !== null) {
            $date = Carbon::parse($this->date)->setTimezone('EAT');
            $this->merge([
                'date' => $date->toDateString(),
            ]);
        }


        if (is_string($this->articles)) {
            $articles = json_decode($this->articles, true);

            foreach ($articles as $key => $article) {
                foreach ($article['quantite'] as $key_quantite => $quantite) {
                    $articles[$key]['quantite'][$key_quantite] = floatval($quantite);
                    # code...
                }
            }


            $this->merge([
                'articles' => $articles,
            ]);

        }

    }

    public function messages(){
        return $this->ValidationMessages();
    }

}
