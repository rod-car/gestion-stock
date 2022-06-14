<?php

namespace App\Models\Depot;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Depot extends Model
{
    use HasFactory;

    /**
     * Tous les champs permet d'assignement de masse
     * NB: point_vente - permet de determiner si un depot est un point de vente ou un entrepot
     *
     * @var array
     */
    protected $fillable = [
        "nom", "localisation", "contact", "point_vente",
    ];



    /**
     * Recuperer tous les travailleurs du dépot
     *
     * @return BelongsToMany
     */
    public function travailleurs() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'travailler', 'personnel', 'id')
            ->withPivot(['est_responsable']);
    }


    /**
     * Recuperer tous les responsables du dépôt
     *
     * @return BelongsToMany
     */
    public function responsables() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'travailler', 'personnel', 'id')
            ->wherePivot('est_responsable', true)
            ->withPivot(['est_responsable']);
    }
}
