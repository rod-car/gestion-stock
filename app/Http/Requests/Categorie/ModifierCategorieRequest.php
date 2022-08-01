<?php

namespace App\Http\Requests\Categorie;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ModifierCategorieRequest extends FormRequest
{
    /**
     * Permet de determiner si l'utilisateur peut executer cette réquête
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return Gate::allows('add_point_vente');
    }

    /**
     * Règles de validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            "libelle" => ["required", Rule::unique("categories")->where(function ($query) {
                $query->where("type", $this->type)->where("id", "<>", $this->categorie->id);
            }), "min:5", "max:255"],
            "description" => ["nullable", "sometimes", "min:5", "max:1000"],
            "type" => ["required", "numeric", "min:1"],
            "sous_categories" => ["nullable", "array"],
            "sous_categories.*" => ["nullable", "exists:categories,id"],
        ];
    }


    /**
     * Messages d'erreurs en cas d'échec de validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            "libelle.unique" => "L'a catégorie est déja dans votre liste de atégorie"
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
            "sous_categories" => collect($this->sous_categories)->pluck('id')->toArray(),
        ]);
    }
}
