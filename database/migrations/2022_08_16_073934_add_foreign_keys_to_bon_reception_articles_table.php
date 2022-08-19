<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBonReceptionArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bon_reception_articles', function (Blueprint $table) {
            $table->foreign(['article'])->references(['id'])->on('articles');
            $table->foreign(['bon_reception'])->references(['id'])->on('bon_receptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bon_reception_articles', function (Blueprint $table) {
            $table->dropForeign('bon_reception_articles_article_foreign');
            $table->dropForeign('bon_reception_articles_bon_reception_foreign');
        });
    }
}
