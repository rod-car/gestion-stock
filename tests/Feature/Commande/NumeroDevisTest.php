<?php

namespace Tests\Feature\Commande;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NumeroDevisTest extends TestCase
{
    /**
     * Test avec aucune enregistrement dans la base de données
     *
     * @test
     * @return void
     */
    public function numero_avec_zero_devis()
    {
        $numero = numeroDevis();
        $this->assertEquals($numero, "D-" . date('Y') . "-" . date("m") . "-" . "0001");
    }

    /**
     * Test avec un enregistrement dans la base de données
     *
     * @test
     * @return void
     */
    public function numero_avec_au_un_devis()
    {
        $numero = numeroDevis();
        $this->assertEquals($numero, "D-" . date('Y') . "-" . date("m") . "-" . "0002");
    }

    /**
     * Test avec au deux enregistrements dans la base de données
     *
     * @test
     * @return void
     */
    public function numero_avec_au_deux_devis()
    {
        $numero = numeroDevis();
        $this->assertEquals($numero, "D-" . date('Y') . "-" . date("m") . "-" . "0003");
    }
}
