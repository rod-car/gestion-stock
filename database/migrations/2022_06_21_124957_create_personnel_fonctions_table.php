<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelFonctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel_fonctions', function (Blueprint $table) {
            $table->unsignedBigInteger('personnel');
            $table->unsignedBigInteger('fonction')->index('fk_fonction');
            $table->timestamp('date_association')->nullable()->useCurrent();

            $table->primary(['personnel', 'fonction']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnel_fonctions');
    }
}
