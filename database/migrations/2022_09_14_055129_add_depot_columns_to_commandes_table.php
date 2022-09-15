<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepotColumnsToCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignId('depot')->nullable(true)->default(null)->comment("Le depot qui a fait la commande ou devis. Uniquement renseigné dans le cas d'un dévis ou commande client")->references('id')->on('depots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('depot');
        });
    }
}
