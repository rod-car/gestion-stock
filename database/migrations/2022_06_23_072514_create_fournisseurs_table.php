<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 255)->unique('nom_fournisseur')->nullable(false)->comment("Nom de la personne ou nom d'une entreprise");
            $table->string('adresse', 255)->nullable(false);
            $table->string('email')->nullable();
            $table->string('contact')->nullable(false);
            $table->string('nif')->nullable();
            $table->string('cif')->nullable();
            $table->string('stat')->nullable();
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
        Schema::dropIfExists('fournisseurs');
    }
}
