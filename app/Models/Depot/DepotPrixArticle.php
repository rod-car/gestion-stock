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


}
