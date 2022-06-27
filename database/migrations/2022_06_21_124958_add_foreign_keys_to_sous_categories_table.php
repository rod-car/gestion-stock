<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSousCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sous_categories', function (Blueprint $table) {
            $table->foreign(['categorie_enfant'], 'fk_categorie_enfant')->references(['id'])->on('categories');
            $table->foreign(['categorie_parent'], 'fk_categorie_parent')->references(['id'])->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sous_categories', function (Blueprint $table) {
            $table->dropForeign('fk_categorie_enfant');
            $table->dropForeign('fk_categorie_parent');
        });
    }
}
