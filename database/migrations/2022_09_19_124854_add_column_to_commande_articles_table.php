<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCommandeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->foreignId('reference_id')->nullable(true)->references('id')->on('depot_prix_articles')->comment("Id pour pour reference de prix dans la table depot_prix_articles");
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
            $table->dropConstrainedForeignId('reference_id');
        });
    }
}
