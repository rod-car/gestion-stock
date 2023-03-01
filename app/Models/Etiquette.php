<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiquette extends Model
{
    use HasFactory;

    public $fillable = ["libelle", "description", "type"];

    CONST TYPE = ["Article", "Fournisseur", "Client"];

    // Selectionner l'index du type d'étiquette
    public function setTypeAttribute($type)
    {
        $this->attributes['type'] = array_search($type, self::TYPE);
    }
}
