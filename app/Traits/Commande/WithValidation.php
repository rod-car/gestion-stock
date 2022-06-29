<?php

namespace App\Traits\Commande;

use Illuminate\Validation\Rule;

trait WithValidation
{
    /**
     * Type de commande possible
     * 1: Dévis
     * 2: Commande proprement dite
     *
     * @var array
     */
    private array $typeCommande = [1, 2];

    /**
     * Règles de validation commun pour tous les request de l'article
     *
     * @param int $exceptId ID a excepter: utile pour la modification - mise a jour
     * @return array
     */
    protected function validationRules(int $exceptId = null): array
    {
        return [
            "numero" => ["required", "unique:commandes,numero,$exceptId,id", "sometimes", "min:2", "max:255"],
            "type" => ["required", Rule::in($this->typeCommande)],
            "date" => ["required", "date", "date_format:d/m/Y H:i:s"],
            "fournisseur" => ["required", "exists:fournisseurs,id"],
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
            "numero.required" => "La réference du dévis est réquis",
            "numero.unique" => "Cette dévis existe déja",
            "numero.min" => "La reference doit être au moins :min caractère",
            "numero.max" => "La reference ne doit pas depasser :max caractère",

            "date.required" => "La date est obligatoire",
            "date.date" => "La doite doit bien être une date",
            "date.date_format" => "Le format de la date est invalide",

            "fournisseur.required" => "Le fournisseur est réquis",
            "fournisseur.exists" => "Veuillez selectionner le fournisseur dans la liste",
        ];
    }
}
