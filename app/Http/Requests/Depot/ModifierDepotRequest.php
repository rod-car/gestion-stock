<?php

namespace App\Http\Requests\Depot;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ModifierDepotRequest extends FormRequest
{
    /**
     * Determiner si l'utilisateur est autorisé a faire ce réquête
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('edit_point_vente');
    }

    /**
     * Règle de validation de la formulaire
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nom" => ["required", "unique:depots,nom,{$this->depot->id},id", "min:2", "max:255"],
            "localisation" => ["required", "sometimes", "min:5", "max:255"],
            "contact" => ["nullable", "sometimes", "min:10", "max:255"],
            "point_vente" => ["required", "boolean", "in:true,false,1,0"],
            "responsables" => ["nullable", "array"],
            "responsables.*" => ["nullable", "exists:users,id"],

            "travailleurs" => ["nullable", "array"],
            "travailleurs.*" => ["nullable", "exists:users,id"],

            "type" => ["required", "numeric", "min:0", "max:3"],
        ];
    }


    /**
     * Message de validation en cas d'erreu
     *
     * @return array
     */
    public function messages()
    {
        return [
            "nom.required" => "Le nom est obligatoire",
        ];
    }

    /**
     * Si la validation échoue
     *
     * @param Validator $validator
     * @return JsonResponse|RedirectResponse
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
     * Modifier quelques proprietes de la requetes avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Construction de tableau d'ID a partir de l'objet et d'autres attributs
        $this->merge([
            "responsables" => collect($this->responsables)->pluck('id')->toArray(),
            "travailleurs" => collect($this->travailleurs)->pluck('id')->toArray(),
            "type" => intval($this->type),
        ]);
    }
}
