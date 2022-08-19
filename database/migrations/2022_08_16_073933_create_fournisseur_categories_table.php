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
            $table->unsignedBigInteger('fournisseur')->index('fournisseur_categories_fournisseur_foreign');
            $table->unsignedBigInteger('categorie');

            $table->primary(['categorie', 'fournisseur']);
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
