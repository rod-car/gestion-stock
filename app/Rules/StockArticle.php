<?php

namespace App\Rules;

use App\Models\Depot\Depot;
use App\Models\Article\DepotArticle;
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

        /** recuperer la clef de l'array */

        $article_index = explode(".", $attribute)[1];
        $article_id = $this->articles[intval($article_index)]['id'];

        if(isset($this->depot_id) && isset($article_id)){

            /** recuperer le stock actuel de l'article dans le depôt */

            $depot = Depot::findOrFail($this->depot_id);

            return floatval($value) <= $depot->articleStock($article_id);
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
