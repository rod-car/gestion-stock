<?php

namespace App\Models\Article;

use App\Models\Article\Article;
use App\Models\Bon\BonReception;
use App\Models\Depot\Depot;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepotArticle extends Model
{
    use HasFactory;

    /**
     * Relations a charger dès la requête
     *
     * @var array
     */
    protected $with = ['getBon', 'article'];


    /**
     * Attributs crée a la volée
     *
     * @var array
     */
    protected $appends = [
        'fullArticle', 'detailsPrix'
    ];


    /**
     * Les colonnes de la base de onnées pour l'assignement de masse
     *
     * @var array
     */
    protected $fillable = [
        "article_id", "quantite", "responsable", "bon", "depot_id", "provenance_id", "destination_id", "date_transaction", "type",
    ];

    /**
     * Recuperer le bon de reception
     *
     * @return BelongsTo
     */
    public function getBon(): BelongsTo
    {
        return $this->belongsTo(BonReception::class, 'bon', 'id');
    }


    /**
     * Recuperer l'article concerné
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    /**
     * Recuperer le depot concerné concerné
     *
     * @return BelongsTo
     */
    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class, 'depot_id', 'id');
    }


    /**
     * Recuperer tous les détails de l'article concerné
     *
     * @return Article
     */
    public function getFullArticleAttribute(): Article
    {
        $commande = $this->getBon->getCommande;
        $article = $commande->getArticle($this->article_id);
        return $article;
    }


    public function getDetailsPrixAttribute()
    {
        $allPrix = DepotPrixArticle::whereArticle($this->article->id)->whereDepot($this->depot->id)->get(["quantite", "pu"]);
        return $allPrix;
    }
}
