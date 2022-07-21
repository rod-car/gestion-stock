<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClientCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_categories', function (Blueprint $table) {
            $table->foreign(['categorie'])->references(['id'])->on('categories');
            $table->foreign(['client'])->references(['id'])->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_categories', function (Blueprint $table) {
            $table->dropForeign('client_categories_categorie_foreign');
            $table->dropForeign('client_categories_client_foreign');
        });
    }
}
