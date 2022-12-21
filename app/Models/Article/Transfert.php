<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'date'];
    public $timestamps = false;

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
}
