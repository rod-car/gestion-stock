<?php

namespace App\Traits\Bon\Reception;

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
            "numero" => ["required", "unique:commandes,numero,$exceptId,id", "sometimes", "min:2", "max:255"],
            "date" => ["required", "date", "date_format:Y-m-d"],

            "articles" => ["required", "array"],
            "articles.*.id" => ["required", "exists:articles,id"],
            "articles.*.quantite" => ["required", "numeric", "min:1", "max:999999999.99"],

            "articles.*.montant_ht" => ["required", "numeric"],
            "articles.*.montant_ttc" => ["required", "numeric"],

            "adresse_livraison" => ["nullable", "sometimes", "min:5", "max:255"],
            "livreur" => ["nullable", "sometimes", "min:5", "max:255"],
            "contact_livreur" => ["nullable", "sometimes", "min:5", "max:255"],

            "commande" => ["nullable", "numeric", "exists:commandes,id"],
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

            "articles.required" => "Les articles du dévis est obligatoire",
            "articles.array" => "Les articles du dévis doit être un tableau",

            "articles.*.id.required" => "Veillez selectionner l'article",
            "articles.*.id.exists" => "Veillez selectionner l'article parmi la liste",

            "articles.*.quantite.required" => "La quantité unitaire est obligatoire",
            "articles.*.quantite.numeric" => "La quantité unitaire doit être un nombre",
            "articles.*.quantite.min" => "La quantité unitaire doit être au moins :min unité",
            "articles.*.quantite.max" => "La quantité unitaire ne doit pas depasser :max unité",
        ];
    }


    /**
     * Retirer soit le fournisseur soit le client en fonction de la situation
     *
     * @return void
     */
    public function toogleClientFrs()
    {
        if ($this->boolean('appro') === true) $this->offsetUnset("client");
        else $this->offsetUnset("fournisseur");
    }
}
