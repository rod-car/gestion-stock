<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_articles', function (Blueprint $table) {
            $table->unsignedBigInteger('article')->index('i_fk_article');
            $table->unsignedBigInteger('bon')->index('i_fk_bon');
            $table->unsignedInteger('quantite');

            $table->primary(['article', 'bon']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bon_articles');
    }
}
