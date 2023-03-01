<?php

namespace App\Rules;

use App\Models\Depot\Depot;
use App\Models\Article\Article;
use App\Models\Article\Transfert;
use App\Models\Article\DepotArticle;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Contracts\Validation\Rule;

class StockArticle implements Rule
{
    private $depot_id;
    private $articles;
    private $transfert;
    private $destiny_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($depot_id, $articles, $transfert = null, $destiny_id = null)
    {
        $this->depot_id = $depot_id;
        $this->articles = $articles;
        $this->transfert = Transfert::find($transfert);
        $this->destiny_id = $destiny_id;
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

        if($this->transfert != null && $this->transfert->count() > 0){
            $quantite_old = $this->transfert->articles->where("id", $article_id)[0]->pivot->quantite;

            if(floatval($quantite_old) > floatval($value)){
                $depot = Depot::findOrFail($this->destiny_id);

                // il faut donc reduire la quantité qui a été transferée et donc verifier la disponiblité dans le depot d'arrivé la quantite en plus
                return (floatval($quantite_old) - floatval($value)) <= ($depot->articleStock($article_id) );

            }else if(floatval($quantite_old) < floatval($value)) {
                $depot = Depot::findOrFail($this->depot_id);
                return  (floatval($value) - floatval($quantite_old)) <= ($depot->articleStock($article_id));
            }

        }
        else{
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
