<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCommandeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->foreign(['article'])->references(['id'])->on('articles');
            $table->foreign(['commande'])->references(['id'])->on('commandes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->dropForeign('commande_articles_article_foreign');
            $table->dropForeign('commande_articles_commande_foreign');
        });
    }
}
