<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_articles', function (Blueprint $table) {
            $table->foreignId('article')->references('id')->on('articles');
            $table->foreignId('commande')->references('id')->on('commandes');
            $table->integer('quantite')->nullable(false);
            $table->decimal('pu', 12, 2)->nullable(false);
            $table->decimal('total', 12, 2)->nullable(false);
            $table->decimal('tva')->nullable(false)->default(20.00);
            $table->primary(['article', 'commande'], 'pk_commande_articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_articles');
    }
}
