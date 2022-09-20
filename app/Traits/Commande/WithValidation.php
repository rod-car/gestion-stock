<?php

namespace App\Traits\Commande;

use Illuminate\Support\Facades\Config;
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
            "date" => ["required", "date", "date_format:Y-m-d"],
            "validite" => ["nullable", "numeric", "min:1", "max:365"],
            "fournisseur" => ["required_if:client,null", "exists:fournisseurs,id"],
            "client" => ["required_if:fournisseur,null", "exists:clients,id"],

            "file" => ["nullable", "file", "mimes:png,jpg,pdf", "max:10000"],

            "articles" => ["required", "array"],
            "articles.*.id" => ["required", "exists:articles,id"],
            "articles.*.pu" => ["required", "numeric", "min:1", "max:" . Config::get("comptable.montant_max")],
            "articles.*.tva" => ["required", "numeric", "min:0", "max:100"],
            "articles.*.quantite" => ["required", "numeric", "min:0.01", "max:999999999.99"],
            "articles.*.object" => ["nullable", "array"],

            "articles.*.montant_ht" => ["required", "numeric"],
            "articles.*.montant_ttc" => ["required", "numeric"],

            "adresse_livraison" => ["nullable", "sometimes", "min:5", "max:255"],

            "devis" => ["nullable", "numeric", "exists:commandes,id"],

            "depot" => ["nullable", "exists:depots,id"],
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

            "validite.required" => "La validité est obligatoire",
            "validite.numeric" => "La validité doit être un nombre",
            "validite.min" => "La validité doit être au moins :min jour",
            "validite.max" => "La validité ne doit pas depasser :max jours",

            "fournisseur.required" => "Le fournisseur est réquis",
            "fournisseur.exists" => "Veuillez selectionner le fournisseur dans la liste",

            "client.required" => "Le client est réquis",
            "client.exists" => "Veuillez selectionner le client dans la liste",

            "articles.required" => "Les articles du dévis est obligatoire",
            "articles.array" => "Les articles du dévis doit être un tableau",

            "articles.*.id.required" => "Veillez selectionner l'article",
            "articles.*.id.exists" => "Veillez selectionner l'article parmi la liste",

            "articles.*.pu.required" => "Le prix unitaire est obligatoire",
            "articles.*.pu.numeric" => "Le prix unitaire doit être un nombre",
            "articles.*.pu.min" => "Le prix unitaire doit être au moins :min Ar",
            "articles.*.pu.max" => "Le prix unitaire ne doit pas depasser :max Ar",

            "articles.*.tva.required" => "Le TVA est obligatoire",
            "articles.*.tva.numeric" => "Le TVA doit être un nombre",
            "articles.*.tva.min" => "Le TVA doit être au moins :min %",
            "articles.*.tva.max" => "Le TVA ne doit pas depasser :max %",

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
