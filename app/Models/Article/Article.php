<?php

namespace App\Models\Article;

use App\Models\Bon\Bon;
use App\Models\Depot\Depot;
use App\Models\Article\Commande;
use App\Models\Categorie\Categorie;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    /**
     * Clé primaire du model
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Type de clé primaire
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Determiner si la clé primaire est en AUTO_INCREMENT
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Charge a l'avance les relations
     * Pour eviter de charger a chaque fois la relation catégorie (Permet de minimiser la réquête)
     *
     * @var array
     */
    protected $with = ['categories'];


    /**
     * Le colonnes de la base de données pour l'assignement de masse
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'designation', 'stock_alert', 'unite', 'description', 'disabled'
    ];

    /**
     * Attribut contenant les sous categories de l'article
     *
     * @var array
     */
    public array $sc = [];


    /**
     * Ajout de l'attribut a la volée
     *
     * @var array
     */
    protected $appends = ["sc"];


    /**
     * Recuperer les sous catégories de l'article
     *
     * @return array
     */
    public function getScAttribute(): array
    {
        return $this->sc;
    }


    /**
     * Permet de récuperer toutes les catégories de l'article
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'article_categories', 'article', 'categorie');
    }

    /**
     * Permet de récuperer toutes les prix de vente s'il exist de l'article
     *
     *
     */
    public function depotPrixArticle(Depot $depot,  $avaible = true, int $prix_id = null)
    {
        return DepotPrixArticle::where("depot", $depot->id)
        ->where("article", $this->id)
        ->when($prix_id != null, function($query) use ($prix_id){
            return $query->where("id", $prix_id);
        })
        ->when($avaible, function($query){
            return $query->where("quantite", ">", 0);
        })
        ->when($avaible === null, function($query){
            return $query->where("quantite", ">", 0)->orWhere("quantite", null);
        });
    }

    public function scopemapAll($query){
        return $query->get()->map(function($res){
            $res["quantity"] = $this->getGlobalStock($res->id);
            return $res;
        });
    }

    public function getGlobalStock($id){
        $entrer = DepotArticle::where("article_id", $id)->where("type", 1)->get()->sum("quantite");
        $sortie = DepotArticle::where("article_id", $id)->where("type", 0)->get()->sum("quantite");

        return $entrer - $sortie;
    }

    /**
     * Permet de récuperer toutes les  articles du bon
     *
     * @return BelongsToMany
     */
    public function bons(): BelongsToMany
    {
        return $this->belongsToMany(Bon::class, 'bon_articles', 'article', 'bon');
    }

    /**
     * Articles concerné par le devis ou commande
     *
     * @return BelongsToMany
     */
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class, 'commande_articles','article', 'commande')
        ->withPivot(['quantite', 'pu', 'tva', 'quantite_recu', 'reference_id']);
    }


}
