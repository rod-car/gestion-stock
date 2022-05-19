<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'reference';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Charge a l'avance les relations
     * Pour eviter de charger a chaque fois la relation catégorie (Permet de minimiser la réquête)
     *
     * @var array
     */
    protected $with = ['categories'];


    /**
     * Permet de récuperer toutes les catégories de l'article
     *
     * @return BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'categorie_articles', 'reference_article', 'categorie_id');
    }
}
