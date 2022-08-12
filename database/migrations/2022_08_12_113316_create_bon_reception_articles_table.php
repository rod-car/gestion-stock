<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonReceptionArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_reception_articles', function (Blueprint $table) {
            $table->foreignId('article')->index('i_fk_article')->references('id')->on('articles');
            $table->foreignId('bon_reception')->index('i_fk_bon_reception')->references('id')->on('bon_receptions');
            $table->unsignedInteger('quantite');
            $table->primary(['article', 'bon_reception']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bon_reception_articles');
    }
}
