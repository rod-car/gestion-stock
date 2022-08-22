<?php

namespace App\Models\Bon;

use App\Models\Article\Article;
use App\Models\Article\Commande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BonReception extends Model
{
    use HasFactory;


    /**
     * Colonnes de la table pour l'assignement de masse
     *
     * @var array
     */
    protected $fillable = [
        "numero", "date", "commande", "status", "adresse_livraison", "livreur", "contact_livreur"
    ];


    /**
     * Relations a charger dès l'execution de la requête
     *
     * @var array
     */
    protected $with = [
        'getCommande', 'articles',
    ];


    /**
     * Recuperer la commande qui a généré le bon de reception
     *
     * @return BelongsTo
     */
    public function getCommande() : BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande', 'id');
    }

    /**
     * Articles de la bon de reception
     *
     * @return BelongsToMany
     */
    public function articles() : BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'bon_reception_articles', 'bon_reception', 'article')->withPivot(['quantite']);
    }
}
