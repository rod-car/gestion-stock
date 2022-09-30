<?php

namespace App\Models\Facture;

use App\Models\Article\Commande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facture extends Model
{
    use HasFactory;

    protected $with = ["getCommande"];

    protected $fillable = [
        "numero_facture", "date_facturation", "date_vente", "echeance", "taux_penalite", "commande"
    ];


    /**
     * Recuperer la commande associé a la facture
     *
     * @return BelongsTo
     */
    public function getCommande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, "commande", "id");
    }
}
