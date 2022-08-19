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
            $table->unsignedBigInteger('article');
            $table->unsignedBigInteger('commande')->index('commande_articles_commande_foreign');
            $table->decimal('quantite', 10);
            $table->decimal('pu', 12);
            $table->decimal('tva')->default(20);
            $table->decimal('quantite_recu', 10)->default(0);

            $table->primary(['article', 'commande']);
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
