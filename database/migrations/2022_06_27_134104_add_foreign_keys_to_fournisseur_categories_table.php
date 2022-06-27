<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFournisseurCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fournisseur_categories', function (Blueprint $table) {
            $table->foreign(['categorie'])->references(['id'])->on('categories');
            $table->foreign(['fournisseur'])->references(['id'])->on('fournisseurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fournisseur_categories', function (Blueprint $table) {
            $table->dropForeign('fournisseur_categories_categorie_foreign');
            $table->dropForeign('fournisseur_categories_fournisseur_foreign');
        });
    }
}
