<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTravaillerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travailler', function (Blueprint $table) {
            $table->foreign(['depot'])->references(['id'])->on('depots');
            $table->foreign(['personnel'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travailler', function (Blueprint $table) {
            $table->dropForeign('travailler_depot_foreign');
            $table->dropForeign('travailler_personnel_foreign');
        });
    }
}
