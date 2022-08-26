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
            $table->bigIncrements('id');
            $table->string('numero')->unique('numero_commande');
            $table->unsignedSmallInteger('type')->comment('Type de commande: 1 - Dévis, 2 - Commande proprement dit');
            $table->date('date');
            $table->integer('validite')->nullable()->comment('Validité du dévis en nombre de jour');
            $table->unsignedBigInteger('fournisseur')->nullable()->index('commandes_fournisseur_foreign');
            $table->unsignedBigInteger('client')->nullable()->index('commandes_client_foreign');
            $table->unsignedBigInteger('devis')->nullable()->index('fk_devis')->comment('Devis dans laquelle provient ce commande. N\'est utile que pour les commandes');
            $table->integer('status')->default(1)->comment('Status du dévis: 1 - Valide');
            $table->timestamps();
            $table->string('adresse_livraison')->nullable()->comment('Adresse de livraison des marchandises dans lecas d\'une commande');
            $table->string('file_path')->nullable();
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
