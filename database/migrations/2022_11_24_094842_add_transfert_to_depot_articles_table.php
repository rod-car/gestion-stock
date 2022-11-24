<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransfertToDepotArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depot_articles', function (Blueprint $table) {
            $table->foreignId('transfert_id')->nullable()->comment("Id de la table transfert")->references('id')->on('transferts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depot_articles', function (Blueprint $table) {
            //
        });
    }
}
