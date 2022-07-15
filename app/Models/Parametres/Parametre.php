<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "generale", "devis",
    ];

    public $casts = [
        "generale" => "json",
    ];

}
