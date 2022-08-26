<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBonReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bon_receptions', function (Blueprint $table) {
            $table->foreign(['commande'])->references(['id'])->on('commandes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bon_receptions', function (Blueprint $table) {
            $table->dropForeign('bon_receptions_commande_foreign');
        });
    }
}
