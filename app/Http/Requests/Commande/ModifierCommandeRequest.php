<?php

namespace App\Http\Requests\Commande;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Traits\Commande\WithValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ModifierCommandeRequest extends FormRequest
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
        return Gate::allows('edit_commande');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = null;
        if (is_object($this->commande)) $id = $this->commande->id;
        else $id = $this->commande;

        return $this->validationRules($id);
    }


    /**
     * Message de validation en cas d'erreurs
     *
     * @return void
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


    /**
     * Traitements avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->toogleClientFrs();

        $this->merge([
            'articles' => json_decode($this->articles, true),
        ]);

        if ($this->date !== null) {
            $date = Carbon::parse($this->date);
            $this->merge([
                'date' => $date->toDateString(),
            ]);
        }
    }
}
