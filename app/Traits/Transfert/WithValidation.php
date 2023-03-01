<?php

namespace App\Traits\Transfert;

use Carbon\Carbon;

trait WithValidation{

    protected function validationRules(): array{
        return [
            'date' => 'required|date|date_format:Y-m-d',
            'depotOrigin' => 'required|exists:depots,id',
            'depotDestiny' => 'required|exists:depots,id',
            'articles' => 'required|array|min:1',
            "articles.*.id" => ["required", "exists:articles,id"],
            "articles.*.quantite" => ["required", "array", "min:1"],
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

            "date.required" => "La date est obligatoire",
            "date.date" => "La doite doit bien être une date",
            "date.date_format" => "Le format de la date est invalide",

            "articles.required" => "Les articles du transfert est obligatoire",
            "articles.array" => "Les articles du transfert doit être un tableau",

            "articles.*.id.required" => "Veillez selectionner l'article",
            "articles.*.id.exists" => "Veillez selectionner l'article parmi la liste",


            "articles.*.quantite.required" => "La quantité unitaire est obligatoire",
            "articles.*.quantite.x.numeric" => "La quantité unitaire doit être un nombre",
            "articles.*.quantite.x.min" => "La quantité unitaire doit être au moins :min unité",
            "articles.*.quantite" => "La quantité unitaire ne doit pas depasser :max unité",
        ];
    }

    protected function beforeValidation(){
        if ($this->numero === null) {
            $numeroTransfert = numeroTransfert();
            $this->merge([
                'numero' => $numeroTransfert,
            ]);
        }


        if ($this->date !== null) {
            $date = Carbon::parse($this->date)->setTimezone('EAT');
            $this->merge([
                'date' => $date->toDateString(),
            ]);
        }


        if (is_string($this->articles)) {
            $articles = json_decode($this->articles, true);

            foreach ($articles as $key => $article) {
                foreach ($article['quantite'] as $key_quantite => $quantite) {
                    $articles[$key]['quantite'][$key_quantite] = floatval($quantite);
                    # code...
                }
            }


            $this->merge([
                'articles' => $articles,
            ]);
        }
    }
}
