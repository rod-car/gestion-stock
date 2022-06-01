<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCategorieArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_articles', function (Blueprint $table) {
            $table->foreign(['reference_article'], 'fk_article')->references(['reference'])->on('articles');
            $table->foreign(['categorie_id'], 'fk_categorie')->references(['id'])->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorie_articles', function (Blueprint $table) {
            $table->dropForeign('fk_article');
            $table->dropForeign('fk_categorie');
        });
    }
}
