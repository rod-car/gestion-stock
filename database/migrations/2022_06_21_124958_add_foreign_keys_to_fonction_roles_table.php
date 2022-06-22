<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFonctionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fonction_roles', function (Blueprint $table) {
            $table->foreign(['fonction'], 'fk_fonction_role')->references(['id'])->on('fonctions');
            $table->foreign(['role'], 'fk_role_fonction')->references(['id'])->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonction_roles', function (Blueprint $table) {
            $table->dropForeign('fk_fonction_role');
            $table->dropForeign('fk_role_fonction');
        });
    }
}
