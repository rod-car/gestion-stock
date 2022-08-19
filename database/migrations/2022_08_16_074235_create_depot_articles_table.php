<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->comment("Id de l'artile a stocker")->references('id')->on('articles');
            $table->decimal('quantite', 10, 2, true)->comment("Quantité de l'article dans la bon de reception")->nullable(false);
            $table->foreignId('responsable')->comment("Id du responsable qui a fait entrer le stock")->references('id')->on('users');
            $table->foreignId('bon')->comment("Bon de livraison ou bon de reception qui contient l'article")->references('id')->on('bon_receptions');
            $table->foreignId('depot_id')->comment('Identifiant du point de vente ou entrepot pour stocker l\'article')->references('id')->on('depots');
            $table->foreignId('provenance_id')->nullable(true)->comment("Identifiant du point de vente ou entrepot où provient l'article. Uniquement utilisé dans le cadre d'un transfert. null si l'article provient d'un fournisseur")->references('id')->on('depots');
            $table->foreignId('destination_id')->nullable(true)->comment("Identifiant du point de vente ou entrepot où on doit deplacer l'article. Uniquement utilisé dans le cadre d'un transfert.")->references('id')->on('depots');
            $table->date('date_transaction')->useCurrent();
            $table->unsignedSmallInteger('type')->default(1)->comment("Type de transaction. Entrée en stock ou sortie de stock. 1: Entree, 0: Sortie");
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
        Schema::dropIfExists('depot_articles');
    }
}
