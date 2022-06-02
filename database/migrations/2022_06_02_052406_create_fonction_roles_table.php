<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonctionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonction_roles', function (Blueprint $table) {
            $table->foreignId('fonction')->references('id')->on('fonctions')->index('fk_fonction_role');
            $table->foreignId('role')->references('id')->on('roles')->index('fk_role_fonction');
            $table->primary(['fonction', 'role'], 'pk_fonction_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fonction_roles');
    }
}
