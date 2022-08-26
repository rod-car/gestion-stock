<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign(['client'])->references(['id'])->on('clients');
            $table->foreign(['devis'], 'fk_devis')->references(['id'])->on('commandes');
            $table->foreign(['fournisseur'])->references(['id'])->on('fournisseurs');
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
            $table->dropForeign('commandes_client_foreign');
            $table->dropForeign('fk_devis');
            $table->dropForeign('commandes_fournisseur_foreign');
        });
    }
}
