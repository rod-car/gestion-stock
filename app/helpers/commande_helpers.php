<?php

use App\Models\Article\Commande;

if (!function_exists('numeroDevis')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de dévis en fonction du dernier devis enregistré
     *
     * @param string $prefix
     * @return string
     */
    function numeroDevis(string $prefix = "D", int $nombreIncrementation = 3): string
    {
        $dernierDevis = Commande::where('type', 1)->orderBy('id', 'desc')->first();
        $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);

        if ($dernierDevis !== null) {
            $dernierNumero = $dernierDevis->numero;
            $parts = explode("-", $dernierNumero);

            $mois = $parts[2];
            $incrementation = $parts[3];

            if (intval(date('m')) === intval($mois)) {
                $incrementation = (string) intval($incrementation) + 1;
                $incrementation = str_pad($incrementation, 4, "0", STR_PAD_LEFT);
            } else {
                $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);
            }
        }

        return $prefix . "-" . date("Y") . "-" . date("m") . "-" . $incrementation;
    }
}
