<?php

namespace App\Models\Depot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepotPrixArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'article', 'depot', 'quantite', 'pu',
    ];

    public static function depotArticlePrixSum($depot_id, $article_id){
        return self::where("depot", $depot_id)->where("article", $article_id)->sum("quantite");
    }

}
