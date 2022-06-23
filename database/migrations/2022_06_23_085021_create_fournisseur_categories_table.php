<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseurCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseur_categories', function (Blueprint $table) {
            $table->foreignId('fournisseur')->references('id')->on('fournisseurs');
            $table->foreignId('categorie')->references('id')->on('categories');
            $table->primary(['categorie', 'fournisseur'], 'pk_fournisseur_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fournisseur_categories');
    }
}
