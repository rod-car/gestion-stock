<?php

namespace App\Models\Depot;

use App\Models\User;
use App\Models\Article\Article;
use App\Models\Depot\Travailler;
use App\Models\Article\DepotArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Depot extends Model
{
    use HasFactory;

    /**
     * Tous les champs permet d'assignement de masse
     * NB: point_vente - permet de determiner si un depot est un point de vente ou un entrepot
     *
     * @var array
     */
    protected $fillable = [
        "nom", "localisation", "contact", "point_vente", "disabled"
    ];


    protected $with = ["responsables", "travailleurs", "articles"];


    /**
     * Recuperer tous les travailleurs du dépot
     *
     * @return BelongsToMany
     */
    public function travailleurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'travailler', 'depot', 'personnel')
            ->withPivot(['est_responsable'])
            ->using(Travailler::class);
    }


    /**
     * Recuperer tous les responsables du dépôt
     *
     * @return BelongsToMany
     */
    public function responsables(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'travailler', 'depot', 'personnel')
            ->wherePivot('est_responsable', true)
            ->withPivot(['est_responsable']);
    }


    /**
     * Listes des articles dans le depot
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'depot_articles', 'depot_id', 'article_id')
            ->withPivot(['quantite', 'responsable', 'bon', 'date_transaction', 'type']);
    }

    /**
     * Stock d'article du depot selon  article
     */

     public function articleStock($article_id){
        $stockArticle = DepotArticle::getDepotArticles($this)
                                        ->get()
                                        ->where('article_id', $article_id)->first();

        $entree = isset($stockArticle->entree) && $stockArticle->entree != null ? floatVal($stockArticle->entree) : 0;
        $sortie = isset($stockArticle->sortie) && $stockArticle->sortie != null ? floatVal($stockArticle->sortie) : 0;

        return floatVal($entree) - floatVal($sortie);
     }

     public function DepotPrixArticle(): HasMany{
        return $this->hasMany(DepotPrixArticle::class,'depot', 'id');
     }

     public static function mapStockArticleParDepot( $article){

        return self::all()->map(function ($depot) use ($article) {
            return [
                "depot" => $depot,
                "stock" => $depot->articleStock($article->id)
            ];
        });
     }
}
