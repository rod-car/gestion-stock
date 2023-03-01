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

            "articles.*.total" => ["required", "numeric", "min:1", "max:999999999.99"],
            "articles.*.valide" => ["required", "boolean"],

            "adresse_livraison" => ["nullable", "sometimes", "min:5", "max:255"],
            "livreur" => ["nullable", "sometimes", "min:2", "max:255"],
            "contact_livreur" => ["nullable", "sometimes", "min:5", "max:255"],

            "depot" => ["required", "exists:depots,id"],

            "commande" => ["nullable", "numeric", "exists:commandes,id"],

            "mode_livraison" => ["required", "numeric", "in:1,2"],
            "a_la_charge_de" => ["required", "numeric", "in:0,1,2"],
            "cout" => ["required", "numeric", "min:0", "max: 9999999999.99"]
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
            "numero.required" => "La réference du devis est réquis",
            "numero.unique" => "Cette devis existe déja",
            "numero.min" => "La reference doit être au moins :min caractère",
            "numero.max" => "La reference ne doit pas depasser :max caractère",

            "date.required" => "La date est obligatoire",
            "date.date" => "La doite doit bien être une date",
            "date.date_format" => "Le format de la date est invalide",

            "articles.required" => "Les articles du devis est obligatoire",
            "articles.array" => "Les articles du devis doit être un tableau",

            "articles.*.id.required" => "Veillez selectionner l'article",
            "articles.*.id.exists" => "Veillez selectionner l'article parmi la liste",

            "articles.*.quantite.required" => "La quantité unitaire est obligatoire",
            "articles.*.quantite.numeric" => "La quantité unitaire doit être un nombre",
            "articles.*.quantite.min" => "La quantité unitaire doit être au moins :min unité",
            "articles.*.quantite.max" => "La quantité unitaire ne doit pas depasser :max unité",

            "mode_livraison.required" => "La mode de livraison est obligatoire",
            "mode_livraison.numeric" => "La mode de livraison doit être parmi la liste",
            "mode_livraison.in" => "La mode de livraison doit être parmi la liste",

            "a_la_charge_de.required" => "Ce qui charge de la livraison est obligatoire",
            "a_la_charge_de.numeric" => "Ce qui charge de la livraison doit être parmi la liste",
            "a_la_charge_de.in" => "Ce qui charge de la livraison doit être parmi la liste",

            "cout.required" => "Le coût de la livraison est obligatoire",
            "cout.numeric" => "Le coût de la livraison doit être numéric",
            "cout.min" => "Le coût de la livraison doit être au moins :min",
            "cout.max" => "Le coût de la livraison ne doit pas depasser :max",
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
