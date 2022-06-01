<?php

namespace App\Models\Personnel;

use App\Models\Role\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model permettant de representer les fonctions dans l'application
 */
class Fonction extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom_fonction", "description_fonction",
    ];


    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
