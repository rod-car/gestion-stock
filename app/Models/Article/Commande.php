<?php

namespace App\Models\Article;

use App\Models\Article\Article;
use App\Models\Client\Client;
use App\Models\Fournisseur\Fournisseur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        "numero", "type", "date", "fournisseur", "client", "devis", "validite" // Uniquement pour les dévis
    ];


    /**
     * Caster la valeur provenant de la base de données
     *
     * @var array
     */
    protected $casts = [
        "date" => "datetime",
    ];


    /**
     * Relations a charger automatiquement
     *
     * @var array
     */
    protected $with = ["frs", "articles"];


    /**
     * Ajouter une nouvelle attributs temporaire au model (Non pas dans la base de données)
     * Utile juste pour l'affichage dans les vues
     *
     * @var array
     */
    protected $appends = ["expire", "date_expiration"];


    /**
     * Compter automatiquement la nombre des articles de ce model
     * Accessible via la proprieté "articles_count"
     *
     * @var array
     */
    protected $withCount = ["articles"];


    /**
     * Recuperer la date d'expiration
     * Utile seulement pour les dévis
     *
     * @return string
     */
    public function getDateExpirationAttribute(): string
    {
        if ($this->type === 2) { // Si c'est une commande, pas de date d'expiration
            return null;
        }

        $date = $this->date;
        $date->addDays($this->validite);

        if ($date->lessThan(now())) $this->status = 2;
        else $this->status = 1;

        $this->save();
        return $date->toDateTimeString();
    }


    /**
     * Recupere l'attribut pour savoir si un dévis est expiré ou non
     *
     * @return boolean
     */
    public function getExpireAttribute(): bool
    {
        if ($this->status === 2) return true;
        return false;
    }

    /**
     * Articles concerné par le devis ou commande
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'commande_articles', 'commande', 'article')
            ->withPivot(['quantite', 'pu', 'tva']);
    }


    /**
     * Recuperer le fournisseur de ce devis
     *
     * @return BelongsTo
     */
    public function frs(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur', 'id');
    }


    /**
     * Recuperer le client pour ce devis
     *
     * @return BelongsTo
     */
    public function cl(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client', 'id');
    }
}
