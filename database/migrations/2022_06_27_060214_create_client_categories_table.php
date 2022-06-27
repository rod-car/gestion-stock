<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_categories', function (Blueprint $table) {
            $table->foreignId('client')->references('id')->on('clients');
            $table->foreignId('categorie')->references('id')->on('categories');
            $table->primary(['categorie', 'client'], 'pk_fournisseur_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_categories');
    }
}
