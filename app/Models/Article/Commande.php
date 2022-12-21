<?php

namespace App\Models\Article;

use Carbon\Carbon;
use App\Models\Client\Client;
use App\Models\Article\Article;
use App\Models\Depot\Depot;
use App\Models\Fournisseur\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    /**
     * Colonnes de la base de données pour l'assignement de masse
     *
     * @var array
     */
    protected $fillable = [
        "numero", "type", "date", "fournisseur", "client", "devis", "adresse_livraison", "depot", "validite" // Uniquement pour les dévis
    ];


    /**
     * Caster la valeur provenant de la base de données
     *
     * @var array
     */
    protected $casts = [];


    /**
     * Relations a charger automatiquement
     *
     * @var array
     */
    protected $with = ["frs", "cl", "articles", "devis"];


    /**
     * Ajouter une nouvelle attributs temporaire au model (Non pas dans la base de données)
     * Utile juste pour l'affichage dans les vues
     *
     * @var array
     */
    protected $appends = ["expire", "date_expiration", "recu", "prix_vent"];


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
    public function getDateExpirationAttribute(): ?string
    {
        if ($this->type === 2) return null; // Si c'est une commande, pas de date d'expiration

        if ($this->validite === null) return null;

        $date = Carbon::parse($this->date);
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
            ->withPivot(['quantite', 'pu', 'tva', 'quantite_recu', 'reference_id']);
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


    /**
     * Devis auquel provient la commande s'il y en a
     *
     * @return BelongsTo
     */
    public function devis(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'devis', 'id');
    }

    /**
     * Permet de savoir si tous les articles d'une commande est récu (Livré par le fournisseur)
     *
     * @return boolean
     */
    public function getRecuAttribute(): bool
    {
        if ($this->type === 1) return false; // Si c'est un devis, pas de reception

        $recu = true;

        foreach ($this->articles as $article)
        {
            if (doubleval($article->pivot->quantite) === doubleval($article->pivot->quantite_recu))
                $recu = boolval($recu AND true);
            else
                $recu = boolval($recu AND false);
        }

        return $recu;
    }


    public function getArticle(int $id)
    {
        return $this->articles()->wherePivot('article', $id)->first();
    }


    /**
     * Permet de recuperer le depot qui a genere la commande
     * Uniquement pour les ventes de marchandises
     *
     * @return BelongsTo
     */
    public function getDepot(): BelongsTo
    {
        return $this->belongsTo(Depot::class, 'depot', 'id');
    }


    public function getPrixVentAttribute(){

        $res = collect();

        if($this->depot){

            foreach ($this->articles as $key => $article) {
                # code...
                $depot = Depot::whereId($this->depot)->first();
                 $price = $article->depotPrixArticle($depot, false);

                 if($this->reference_id === null) $price->where('depot_prix_articles.quantite', null);
                 else $price->where('depot_prix_articles.id', $this->reference_id);

                 $res->push($price->first());
            }
        }
        return $res;
    }


}
