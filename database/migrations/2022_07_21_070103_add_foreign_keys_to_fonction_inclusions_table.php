<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFonctionInclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fonction_inclusions', function (Blueprint $table) {
            $table->foreign(['fonction_enfant'])->references(['id'])->on('fonctions');
            $table->foreign(['fonction_parent'])->references(['id'])->on('fonctions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonction_inclusions', function (Blueprint $table) {
            $table->dropForeign('fonction_inclusions_fonction_enfant_foreign');
            $table->dropForeign('fonction_inclusions_fonction_parent_foreign');
        });
    }
}
