<?php

namespace App\Traits\Article;

use Illuminate\Validation\Rule;

trait WithValidation
{
    /**
     * Règles de validation commun pour tous les request de l'article
     *
     * @param int $exceptId ID a excepter: utile pour la modification - mise a jour
     * @return array
     */
    protected function validationRules(int $exceptId = null): array
    {
        return [
            "reference" => ["required", "unique:articles,reference,$exceptId,id", "sometimes", "min:2", "max:255"],
            "designation" => ["required", "unique:articles,designation,$exceptId,id", "sometimes", "min:2", "max:255"],
            "unite" => ["required", "sometimes", "min:1", "max:255"],
            "stock_alert" => ["nullable", "numeric", "min:0", "max:999999999999"],

            "categories" => ["required"],
            "categories.*" => ["required", Rule::exists("categories", "id")->where("type", 3)],
        ];
    }


    /**
     * Message de validation pour la création et modification de l'article
     *
     * @return array
     */
    protected function ValidationMessages(): array
    {
        return [
            "reference.required" => "Le réference de l'article est réquis",
            "reference.unique" => "Ce article existe déja",
            "reference.min" => "La reference doit être au moins :min caractère",
            "reference.max" => "La reference ne doit pas depasser :max caractère",

            "unite.required" => "L'unité de l'article est réquis",
            "unite.min" => "L'unité doit être au moins :min caractère",
            "unite.max" => "L'unité ne doit pas depasser :max caractère",

            "designation.required" => "Le désignation du article est réquis",
            "designation.unique" => "Ce article existe déja",
            "designation.min" => "La désignation doit être au moins :min caractère",
            "designation.max" => "La désignation ne doit pas depasser :max caractère",

            "stock_alert.numeric" => "Le stock d'alerte doit être un chiffre",
            "stock_alert.min" => "Le stock d'alerte doit être au moins :min unité",
            "stock_alert.max" => "Le stock d'alerte ne doit pas depasser :max unité",

            "categories.required" => "Les catégories de l'article est obligatoire",
            "categories.*.required" => "Veuillez selectionner les catégories dans la liste",
            "categories.*.exists" => "Veuillez selectionner les catégories dans la liste",
        ];
    }
}
