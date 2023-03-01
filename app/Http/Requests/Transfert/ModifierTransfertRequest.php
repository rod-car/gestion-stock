<?php

namespace App\Http\Requests\Transfert;

use App\Rules\StockArticle;
use App\Traits\Transfert\WithValidation;
use Illuminate\Foundation\Http\FormRequest;


class ModifierTransfertRequest extends FormRequest
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
        return $this->validationRules()
        + [
            "articles.*.quantite.*" => ["sometimes", "numeric", new StockArticle($this->depotOrigin, $this->articles, request()->route("transfert_article"), $this->depotDestiny)],
        ];;
    }

    /**
     * Traitements avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->beforeValidation();
    }
}
