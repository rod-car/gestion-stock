<?php

use App\Models\Article\Commande;

if (!function_exists('reference')) {
    /**
     * Generer la reference d'une commande ou dévis
     *
     * @param integer $type
     * @param boolean $appro
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string|null
     */
    function reference(int $type, bool $appro = true, string $prefix = "D", int $nombreIncrementation = 4) : ?string
    {
        if ($type === 1) return numeroDevis($appro, $prefix, $nombreIncrementation);
        elseif ($type === 2) return numeroCommande($appro, $prefix, $nombreIncrementation);
        else return null;
    }
}

if (!function_exists('numeroDevis')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de dévis en fonction du dernier devis enregistré
     *
     * @param boolean $appro
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string
     */
    function numeroDevis(bool $appro = true, string $prefix = "D", int $nombreIncrementation = 4): string
    {
        $dernierDevis = Commande::where('type', 1)->orderBy('id', 'desc');

        if ($appro)
        {
            $dernierDevis = $dernierDevis->where('fournisseur', '<>', null)->first();
            $prefix = "{$prefix}F";
        }
        else
        {
            $dernierDevis = $dernierDevis->where('client', '<>', null)->first();
            $prefix = "{$prefix}C";
        }

        $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);

        if ($dernierDevis !== null) {
            $dernierNumero = $dernierDevis->numero;
            $parts = explode("-", $dernierNumero);

            $mois = $parts[2];
            $incrementation = $parts[3];

            if (intval(date('m')) === intval($mois)) {
                $incrementation = (string) intval($incrementation) + 1;
                $incrementation = str_pad($incrementation, $nombreIncrementation, "0", STR_PAD_LEFT);
            } else {
                $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);
            }
        }

        return $prefix . "-" . date("Y") . "-" . date("m") . "-" . $incrementation;
    }
}


if (!function_exists('numeroCommande')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de la commande en fonction de la dernière commande enregistré
     *
     * @param boolean $appro
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string
     */
    function numeroCommande(bool $appro = true, string $prefix = "BC", int $nombreIncrementation = 4): string
    {
        $dernierDevis = Commande::where('type', 2)->orderBy('id', 'desc');

        if ($appro)
        {
            $dernierDevis = $dernierDevis->where('fournisseur', '<>', null)->first();
            $prefix = "{$prefix}F";
        }
        else
        {
            $dernierDevis = $dernierDevis->where('client', '<>', null)->first();
            $prefix = "{$prefix}C";
        }

        $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);

        if ($dernierDevis !== null) {
            $dernierNumero = $dernierDevis->numero;
            $parts = explode("-", $dernierNumero);

            $mois = $parts[2];
            $incrementation = $parts[3];

            if (intval(date('m')) === intval($mois)) {
                $incrementation = (string) intval($incrementation) + 1;
                $incrementation = str_pad($incrementation, $nombreIncrementation, "0", STR_PAD_LEFT);
            } else {
                $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);
            }
        }

        return $prefix . "-" . date("Y") . "-" . date("m") . "-" . $incrementation;
    }
}
