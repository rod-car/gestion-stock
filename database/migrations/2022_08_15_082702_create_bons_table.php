<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('type')->nullable(false)->default(1)->comment("Permet de savoir si c'est un bon de reception ou un bon de livraison. 1: Bon de reception, 2: Bon de livraison");
            $table->string('numero')->unique('numero_bon');
            $table->date('date');
            $table->unsignedBigInteger('commande')->nullable()->index('fk_commande');
            $table->integer('status')->default(1)->comment('Status de bon');
            $table->string('adresse_livraison')->nullable()->comment('Adresse de livraison des marchandises');
            $table->string('livreur')->nullable()->comment('Nom du livreur de la marchandise');
            $table->string('contact_livreur')->nullable()->comment('Contact du livreur');
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
        Schema::dropIfExists('bons');
    }
}
