<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonctionInclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonction_inclusions', function (Blueprint $table) {
            $table->foreignId('fonction_parent')->references('id')->on('fonctions');
            $table->foreignId('fonction_enfant')->references('id')->on('fonctions');
            $table->primary(['fonction_parent', 'fonction_enfant'], 'pk_fonction_inclusion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fonction_inclusions');
    }
}
