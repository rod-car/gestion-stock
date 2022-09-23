<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLivraisonDetailsToBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bons', function (Blueprint $table) {
            $table->unsignedSmallInteger('mode_livraison')->nullable()->default(1)->after('contact_livreur')->comment("Mode de livraison du bon. 1: Fournisseur qui livre, 2: Client qui le recupère chez le fournisseur");
            $table->unsignedSmallInteger('a_la_charge_de')->nullable()->after('mode_livraison')->comment("Qui se charge de payer le cout de livraison s'il y en a. 0: Aucun, 1: Fournisseur, 2: Client");
            $table->decimal('cout', 10, 2)->nullable()->after('a_la_charge_de')->comment("Coût de livraison de l'article s'il y en a");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bons', function (Blueprint $table) {
            $table->dropColumn('mode_livraison');
            $table->dropColumn('a_la_charge_de');
            $table->dropColumn('cout');
        });
    }
}
