<?php

namespace App\Models\Article;

use App\Models\Article\Article;
use App\Models\Article\DepotArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfert extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'date'];

    public $timestamps = false;


    /**
     * Caster la valeur provenant de la base de données
     *
     * @var array
     */
    protected $casts = [
        'date'  => 'date:d-m-Y',
    ];

   /**
    * The articles that belong to the Transfert
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function articles()
   {
       return $this->belongsToMany(Article::class, 'depot_articles', 'transfert_id', 'article_id')
                    ->withPivot('type', 'quantite', 'depot_id', 'provenance_id', 'destination_id');;
   }

   public function articleQuantite($article_id){
    return DepotArticle::where("transfert_id", $this->id)->where("article_id", $article_id)->where("type", 0)->sum("quantite");
   }
}
