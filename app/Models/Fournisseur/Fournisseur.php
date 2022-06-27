<?php

namespace App\Models\Fournisseur;

use App\Models\Categorie\Categorie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom", "adresse", "email", "contact", "nif", "cif", "stat",
    ];


    protected $with = ["categories"];

    /**
     * Categories du fournisseur
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'fournisseur_categories', 'fournisseur', 'categorie');
    }
}
