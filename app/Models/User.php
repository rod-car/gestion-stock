<?php

namespace App\Models;

use App\Models\Personnel\Fonction;
use App\Models\Role\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_personnel', 'prenoms_personnel', 'contact_personnel', 'adresse_personnel', 'cin_personnel', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Charges les relations
     *
     * @var array
     */
    protected $with = ['roles', 'fonctions'];


    /**
     * Compte automatique le nombre des roles
     *
     * @var array
     */
    protected $withCount = ['roles'];


    /**
     * Hasher automatiquement un mot de passe et le dehasher si necessaire
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(?string $value)
    {
        if (strpos($value, '_') === 0)
        {
            $this->attributes['password'] = Crypt::decrypt(str_replace('_', '', $value));
        }
        else
        {
            if ($value !== null) $this->attributes['password'] = Crypt::encrypt($value);
            else $this->attributes['password'] = null;
        }
    }


    /**
     * Recuperer toutes les roles de l'utilisateur
     *
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }


    /**
     * Permet de recuperer tous les fonctions du personnel
     *
     * @return BelongsToMany
     */
    public function fonctions() : BelongsToMany
    {
        return $this->belongsToMany(Fonction::class, 'personnel_fonctions', 'personnel', 'fonction')->withPivot(['date_association ']);
    }
}
