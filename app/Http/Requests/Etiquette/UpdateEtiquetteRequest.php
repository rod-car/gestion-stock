<?php

namespace App\Http\Requests\Etiquette;

use App\Models\Etiquette;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEtiquetteRequest extends FormRequest
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
            "libelle" => ["required", "unique:etiquettes,libelle," . $this->, "min:5", "max:255"],
            "description" => ["nullable", "sometimes", "min:5", "max:1000"],
            "type" => ["required", "in:" . implode(",", Etiquette::TYPE)]
        ];
    }
}
