<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_receptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero')->unique('numero_commande');
            $table->date('date')->useCurrent();
            $table->foreignId('commande')->nullable()->index('fk_commande')->references('id')->on('commandes')->comment('Numéro de la commande qui a generé le bon de reception');
            $table->integer('status')->default(1)->comment('Status de bon de reception');
            $table->string('adresse_livraison')->nullable()->comment('Adresse de livraison des marchandises');
            $table->string('livreur')->nullable(true)->comment('Nom du livreur de la marchandise');
            $table->string('contact_livreur')->nullable(true)->comment('Contact du livreur');
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
        Schema::dropIfExists('bon_receptions');
    }
}
