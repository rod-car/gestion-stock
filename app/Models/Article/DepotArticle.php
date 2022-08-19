<?php

namespace App\Models\Article;

use App\Models\Article\Article;
use App\Models\Bon\BonReception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepotArticle extends Model
{
    use HasFactory;

    protected $with = ['getBon', 'article'];

    protected $appends = [
        'fullArticle'
    ];

    protected $fillable = [
        "article_id", "quantite", "responsable", "bon", "depot_id", "provenance_id", "destination_id", "date_transaction", "type",
    ];

    public function getBon(): BelongsTo
    {
        return $this->belongsTo(BonReception::class, 'bon', 'id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function getFullArticleAttribute()
    {
        $commande = $this->getBon->getCommande;
        $article = $commande->getArticle($this->article_id);
        return $article;
    }
}
