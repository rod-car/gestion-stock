<?php

namespace App\Models\Bon;

use App\Models\Article\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BonReception extends Model
{
    use HasFactory;

    protected $fillable = [
        "numero", "date", "commande", "status", "adresse_livraison", "livreur", "contact_livreur"
    ];


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
