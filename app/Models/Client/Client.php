<?php

namespace App\Models\Client;

use App\Models\Categorie\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom", "adresse", "email", "contact", "nif", "cif", "stat",
    ];

    protected $with = ["categories"];

    /**
     * Categories du client
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'client_categories', 'client', 'categorie');
    }
}
