<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference')->unique('reference');
            $table->string('designation')->nullable();
            $table->string('unite')->default('Nombre');
            $table->longText('description')->nullable();
            $table->boolean('disabled')->nullable()->default(false);
            $table->timestamps();
            $table->decimal('stock_alert', 12)->unsigned()->nullable()->comment('Quantité en stock restant pour alerter l\'utilisateur pour un appro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
