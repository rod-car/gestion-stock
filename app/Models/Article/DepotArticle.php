<?php

namespace App\Models\Article;

use App\Models\Bon\Bon;
use App\Models\Depot\Depot;
use App\Models\Article\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;


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
        "article_id", "quantite", "responsable", "bon", "depot_id", "provenance_id", "destination_id", "date_transaction", "type", "transfert_id"
    ];

    /**
     * Recuperer le bon de reception
     *
     * @return BelongsTo
     */
    public function getBon(): BelongsTo
    {
        return $this->belongsTo(Bon::class, 'bon', 'id');
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
    public function getFullArticleAttribute(): ?Article
    {
        if ($this->getBon()->count() === 0) {
            return null;
        }

        $commande = $this->getBon->getCommande;
        $article = $commande->getArticle($this->article_id);
        return $article;
    }


    public function getDetailsPrixAttribute(): ?Collection
    {
        $allPrix = DepotPrixArticle::whereArticle($this->article->id)->where(function($query){
            $query->where('quantite', '>', 0)->orWhere('quantite', '=', null);
        });
        if ($this->article()->count() === 0 || $allPrix->count() === 0) return null;


        $depot_id = $this->depot->id;

        $allPrix->when($this->depot()->count() > 0, function($q) use($depot_id){
            return $q->whereDepot($depot_id);
        });

        $allPrix = $allPrix->orderBy("id", "desc")->get(["id", "article", "quantite", "pu"]);
        $res = new Collection;

        foreach ($allPrix as $key => $value) {
            # code...
            $isExist = false;
            foreach ($res as $key2 => $value2) {
                # code...
                if(
                    $value->article == $value2->article &&
                    $value->quantite == $value2->quantite && $value->pu == $value2->pu &&
                    $value->quantite === null) $isExist = true;
            }

            if(!$isExist) $res->push($value);
        }

        return $res;
    }

    /**
     * Recupere tous les articles d'un dépot ou tous les dépots articles
     *
     * @param Depot|null $depot Le depot concerné
     * @return Builder
     */
    public static function getDepotArticles(?Depot $depot = null, ?string $by = null)
    {
        $depotArticle = self::query()
            ->selectRaw("articles.id as article_id")
            ->selectRaw("(select art.reference from articles as art where art.id = articles.id LIMIT 1) as reference")
            ->selectRaw("(select art.designation from articles as art where art.id = articles.id LIMIT 1) as designation")
            ->selectRaw("(select art.unite from articles as art where art.id = articles.id LIMIT 1) as unite")
            ->selectRaw("(select dep.depot_id from depot_articles as dep where dep.article_id = articles.id AND dep.depot_id = depot_articles.depot_id LIMIT 1) as depot_id")
            ->selectRaw("(select dep.bon from depot_articles as dep where dep.article_id = articles.id LIMIT 1) as bon")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 1 THEN quantite END) as entree")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 0 THEN quantite END) as sortie")
            ->rightJoin('articles', 'articles.id', '=', 'depot_articles.article_id');

        $groupby = ['articles.id', 'depot_articles.depot_id'];

        if ($depot !== null) {
            $depotArticle = $depotArticle->where('depot_id', $depot->id)->orWhere('depot_id', null);
            //$groupby[] = 'depot_articles.depot_id';
        }

        $depotArticle = $depotArticle->groupBy($groupby);

        if ($by !== null) $depotArticle = $depotArticle->groupBy($by);

        return $depotArticle;
    }

    public static function createDepotAritcle($data, $type = 0){

        return    self::create([
                        "article_id" => $data['article_id'],
                        "quantite" => $data['quantite'],
                        "responsable" => Auth::user()->id,
                        "bon" => null,
                        "transfert_id" => $data["transfert_id"],
                        "depot_id" => $data['depot_id'],
                        "provenance_id" => isset($data['depotOrigin']) ? $data['depotOrigin'] : null ,
                        "destination_id" => isset($data['depotDestiny']) ? $data['depotDestiny'] : null,
                        "date_transaction" => today()->toDateString(),
                        "type" => $type,
                    ]);
    }
}
