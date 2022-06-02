<?php

namespace App\Models\Personnel;

use App\Models\Role\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model permettant de representer les fonctions dans l'application
 */
class Fonction extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom_fonction", "description_fonction",
    ];

    protected $with = ['permissions'];

    protected $withCount = ['personnelles'];

    protected $appends = ['permissionIds'];


    public function getPermissionIdsAttribute()
    {
        return $this->permissions()->pluck('id');
    }

    /**
     * Relation pour recuperer les permissions associé a la fonction
     *
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'fonction_roles', 'fonction', 'role');
    }


    /**
     * Recuperer toutes les personnels occupant cette fonction
     *
     * @return BelongsToMany
     */
    public function personnelles() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'personnel_fonctions', 'fonction', 'personnel');
    }
}
