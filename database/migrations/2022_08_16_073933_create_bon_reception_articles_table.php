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
            $table->unsignedBigInteger('article')->index('i_fk_article');
            $table->unsignedBigInteger('bon_reception')->index('i_fk_bon_reception');
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
