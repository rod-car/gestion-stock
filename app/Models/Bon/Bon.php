<?php

namespace App\Models\Bon;

use App\Models\Article\Article;
use App\Models\Article\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bon extends Model
{
    use HasFactory;

    /**
     * Colonnes de la table pour l'assignement de masse
     *
     * @var array
     */
    protected $fillable = [
        "numero", "date", "commande", "type", "status", "adresse_livraison", "livreur", "contact_livreur",
        "mode_livraison", "a_la_charge_de", "cout",
    ];


    /**
     * Caster la valeur provenant de la base de données
     *
     * @var array
     */
    protected $casts = [
        'date'  => 'date:d-m-Y',
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
    public function getCommande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande', 'id');
    }

    /**
     * Articles de la bon de reception
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'bon_articles', 'bon', 'article')->withPivot(['quantite']);
    }
}
