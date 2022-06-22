<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravaillerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travailler', function (Blueprint $table) {
            $table->unsignedBigInteger('personnel');
            $table->unsignedBigInteger('depot')->index('travailler_depot_foreign');
            $table->boolean('est_responsable')->default(false)->comment('Permet de determiner si le personnel est responsable de ce depot');
            $table->timestamps();

            $table->primary(['personnel', 'depot']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travailler');
    }
}
