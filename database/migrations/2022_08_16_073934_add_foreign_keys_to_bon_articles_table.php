<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToBonArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bon_articles', function (Blueprint $table) {
            $table->foreign(['article'])->references(['id'])->on('articles');
            $table->foreign(['bon'])->references(['id'])->on('bons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bon_articles', function (Blueprint $table) {
            $table->dropForeign('bon_articles_article_foreign');
            $table->dropForeign('bon_articles_bon_foreign');
        });
    }
}
