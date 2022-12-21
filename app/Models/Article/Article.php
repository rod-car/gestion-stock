<?php

namespace App\Models\Article;

use App\Models\Categorie\Categorie;
use App\Models\Depot\Depot;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\Boolean;

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
        'reference', 'designation', 'stock_alert', 'unite', 'description',
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
    public function depotPrixArticle(Depot $depot, bool $avaible = true, int $prix_id = null)
    {
        return DepotPrixArticle::where("depot", $depot->id)
        ->where("article", $this->id)
        ->when($prix_id != null, function($query) use ($prix_id){
            return $query->where("id", $prix_id);
        })
        ->when($avaible, function($query){
            return $query->where("quantite", ">", 0);
        });
    }
}
