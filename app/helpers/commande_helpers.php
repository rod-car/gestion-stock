<?php

use App\Models\Article\Commande;
use App\Models\Bon\Bon;
use App\Models\Bon\BonLivraison;
use App\Models\Facture\Facture;

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
    function reference(int $type, ?bool $appro = true, string $prefix = "D", int $nombreIncrementation = 4) : ?string
    {
        if ($type === 1) return numeroDevis($appro, $prefix, $nombreIncrementation);
        elseif ($type === 2) return numeroCommande($appro, $prefix, $nombreIncrementation);
        elseif ($type === 3) return numeroBonReception($prefix, $nombreIncrementation);
        elseif ($type === 4) return numeroBonLivraison($prefix, $nombreIncrementation);
        elseif ($type === 5) return numeroFacture($prefix, $nombreIncrementation);
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
                $incrementation = strval(intval($incrementation) + 1);
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

if (!function_exists('numeroBonReception')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de bon de reception en fonction du dernier dans la base de données
     *
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string
     */
    function numeroBonReception(string $prefix = "BR", int $nombreIncrementation = 4): string
    {
        $dernierDevis = Bon::whereType(1)->orderBy('id', 'desc')->first();
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


if (!function_exists('numeroBonLivraison')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de bon de livraison en fonction du dernier dans la base de données
     *
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string
     */
    function numeroBonLivraison(string $prefix = "BL", int $nombreIncrementation = 4): string
    {
        $dernierDevis = Bon::whereType(2)->orderBy('id', 'desc')->first();
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


if (!function_exists('numeroFacture')) {
    /**
     * Fonction qui permet de generer un nouveau numéro de bon de livraison en fonction du dernier dans la base de données
     *
     * @param string $prefix
     * @param integer $nombreIncrementation
     * @return string
     */
    function numeroFacture(string $prefix = "FAC", int $nombreIncrementation = 4): string
    {
        $dernierDevis = Facture::orderBy('id', 'desc')->first();
        $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);

        if ($dernierDevis !== null) {
            $dernierNumero = $dernierDevis->numero;
            $incrementation = getIncrementation($dernierNumero, $nombreIncrementation, "-");
        }

        return $prefix . "-" . date("Y") . "-" . date("m") . "-" . $incrementation;
    }
}


if (!function_exists('getIncrementation')) {
    /**
     * Recuperer le nombre d'incrémentation en fonction du precedent
     * Ex: 0001
     *
     * @return string
     */
    function getIncrementation(string $numero, int $nombreIncrementation, string $separateur): string {
        $parts = explode($separateur, $numero);

        $mois = $parts[2];
        $incrementation = $parts[3];

        if (intval(date('m')) === intval($mois)) {
            $incrementation = (string) intval($incrementation) + 1;
            $incrementation = str_pad($incrementation, $nombreIncrementation, "0", STR_PAD_LEFT);
        } else {
            $incrementation = str_pad("1", $nombreIncrementation, "0", STR_PAD_LEFT);
        }

        return $incrementation;
    }
}
