<?php

namespace App\Models\Categorie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        "id", "libelle", "description", "type", "parent",
    ];


    protected $with = ['sousCategories'];


    /**
     * Recuperer les sous categories de la catégorie
     *
     * @return BelongsToMany
     */
    public function sousCategories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'sous_categories', 'categorie_parent', 'categorie_enfant');
    }


    /**
     * Recuperer les parents categories de la catégorie
     *
     * @return BelongsToMany
     */
    public function parentCategories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'sous_categories', 'categorie_enfant', 'categorie_parent');
    }
}
