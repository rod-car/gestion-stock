<?php

namespace App\Models\Depot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Travailler extends Pivot
{
    protected $casts = [
        'est_responsable' => 'boolean'
    ];
}
