<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string("numero_facture")->nullable(false)->unique("numero_facture");
            $table->date('date_facturation')->nullable(false)->useCurrent();
            $table->date('date_vente')->nullable(false);
            $table->unsignedInteger('echeance')->nullable(false)->default(30)->comment("Nombre d'écheance en jours.");
            $table->decimal('taux_penalite', 10, 2)->nullable(false);
            $table->foreignId('commande')->nullable(true)->comment("Numéro de bon de commande qui a généré la facture")->references('id')->on('commandes');
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
        Schema::dropIfExists('factures');
    }
}
