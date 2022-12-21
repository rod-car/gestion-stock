<?php

namespace App\Rules;

use App\Models\Article\Article;
use App\Models\Depot\Depot;
use App\Models\Article\DepotArticle;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Contracts\Validation\Rule;

class StockArticle implements Rule
{
    private $depot_id;
    private $articles;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($depot_id, $articles)
    {
        $this->depot_id = $depot_id;
        $this->articles = $articles;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if($value === null) return true;

        /** recuperer la clef de l'array */

        $article_index = explode(".", $attribute)[1];
        $prix_id = explode(".", $attribute)[3];

        $article_id = $this->articles[intval($article_index)]['id'];

        if(isset($this->depot_id) && isset($article_id)){

            /** recuperer le stock actuel de l'article dans le depôt */

            $depot = Depot::findOrFail($this->depot_id);

            if($prix_id == 0) {
                // combiné les quantités sepecifiques par prix au quantité restant avant de le comparer avec les quantité stock actuel
                $stockPrixVarie = DepotPrixArticle::whereArticle($article_id)->whereDepot($this->depot_id)->where("quantite", ">", 0)->sum("quantite");

                return floatval($value) <= ($depot->articleStock($article_id) - $stockPrixVarie);
            }

            if(floatval($value) == 0) return true;

            return floatval($value) <= floatval(DepotPrixArticle::find($prix_id)->quantite);

        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stock insuffisant';
    }
}
