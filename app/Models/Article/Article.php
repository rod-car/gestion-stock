<?php

namespace App\Models\Article;

use App\Models\Categorie\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Charge a l'avance les relations
     * Pour eviter de charger a chaque fois la relation catégorie (Permet de minimiser la réquête)
     *
     * @var array
     */
    protected $with = ['categories'];


    protected $fillable = [
        'reference', 'designation', 'stock_alert', 'unite',
    ];

    public array $sc = [];

    protected $appends = ["sc"];

    public function getScAttribute()
    {
        return $this->sc;
    }


    /**
     * Permet de récuperer toutes les catégories de l'article
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'article_categories', 'article', 'categorie');
    }
}
