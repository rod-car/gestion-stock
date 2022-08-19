<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPersonnelFonctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personnel_fonctions', function (Blueprint $table) {
            $table->foreign(['fonction'], 'fk_fonction')->references(['id'])->on('fonctions');
            $table->foreign(['personnel'], 'fk_personnel')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personnel_fonctions', function (Blueprint $table) {
            $table->dropForeign('fk_fonction');
            $table->dropForeign('fk_personnel');
        });
    }
}
