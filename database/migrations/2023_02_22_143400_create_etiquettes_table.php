<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtiquettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquettes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('description')->nullable();
            $table->integer('type')->comment('Type de la catégorie: 1-Client, 2-Article, 3-Frs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etiquettes');
    }
}
