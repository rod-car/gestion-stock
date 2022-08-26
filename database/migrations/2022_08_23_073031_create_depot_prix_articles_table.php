<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotPrixArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_prix_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article')->references('id')->on('articles');
            $table->foreignId('depot')->references('id')->on('depots');
            $table->decimal('quantite', 10)->unsigned()->nullable(true)->default(null)->comment('Null si tous les autres articles sont concerné par le prix');
            $table->decimal('pu', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depot_prix_articles');
    }
}
