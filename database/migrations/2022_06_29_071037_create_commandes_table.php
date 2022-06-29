<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable(false)->unique('numero_commande');
            $table->smallInteger('type', false, true)->comment("Type de commande: 1 - Dévis, 2 - Commande proprement dit");
            $table->dateTime('date')->useCurrent();
            $table->foreignId('fournisseur')->references('id')->on('fournisseurs')->nullable(true)->comment("Fournisseur qui doit recevoir la commande. Null s'il ya pas d'appro.");
            $table->foreignId('client')->references('id')->on('clients')->nullable(true)->comment("Client qui a fait la commande. Null s'il ya pas de vente");
            $table->foreignId('devis')->references('id')->on('commandes')->nullable(true)->comment("Devis dans laquelle provient ce commande. N'est utile que pour les commandes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
}
