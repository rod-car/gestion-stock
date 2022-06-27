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
            $table->unsignedBigInteger('fonction_parent');
            $table->unsignedBigInteger('fonction_enfant')->index('fonction_inclusions_fonction_enfant_foreign');

            $table->primary(['fonction_parent', 'fonction_enfant']);
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
