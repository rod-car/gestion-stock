<?php

namespace App\Http\Controllers\Api\Bon;

use App\Models\Bon\Bon;
use App\Models\Depot\Depot;
use App\Models\Article\Commande;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Bon\Livraison\NouveauBonLivraisonRequest;
use App\Http\Requests\Bon\Livraison\ModifierBonLivraisonRequest;
use App\Http\Resources\Bon\BonLivraisonResource;

class BonLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bon::whereType(2)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Bon\Livraison\NouveauBonLivraisonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauBonLivraisonRequest $request)
    {
        $data = $request->validated();
        $data["type"] = 2; // Pour indiquer que c'est un bon de livraison client
        $articles = $data["articles"];
        unset($data["articles"]);

        $commande = Commande::findOrFail($data['commande']);
        $livraison = Bon::create($data);

        $this->updateArticles($livraison, $articles);
        $this->updateCommandeArticles($commande, $articles);
        $this->updateDepotArticles($livraison, $commande->getDepot, $articles);

        return $livraison;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon\Bon  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(Bon $bonLivraison)
    {
        return $bonLivraison;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Bon\Livraison\ModifierBonLivraisonRequest  $request
     * @param  \App\Models\Bon\Bon  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierBonLivraisonRequest $request, Bon $bonLivraison)
    {
        $bonLivraison->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon\Bon  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bon $bonLivraison)
    {
        $bonLivraison->articles()->detach();
        $bonLivraison->delete();
    }

    /**
     * Permet de mettre a jour les articles d'un bon de livraison
     *
     * @param Bon $livraison Bon de livraison
     * @param array $articles Tableau contenant les articles
     * @return void
     */
    public function updateArticles(Bon $livraison, array $articles)
    {
        foreach ($articles as $article) {
            $livraison->articles()->attach($article['id'], [
                "quantite" => abs($article["quantite"])
            ]);
        }
    }


    /**
     * Permet de mettre a jour les articles associé a la commande
     *
     * @param Commande $commande La commande
     * @param array $articles Tableau contenat les articles
     * @return void
     */
    public function updateCommandeArticles(Commande $commande, array $articles)
    {
        foreach ($articles as $article) {
            $tmp = $commande->articles()->wherePivot('article', $article['id'])->first();
            if ($tmp !== null) {
                $commande->articles()->updateExistingPivot($article['id'], [
                    'quantite_recu' => $tmp->pivot->quantite_recu + doubleval($article['quantite']),
                ]);
            }
        }
    }

    /**
     * Permet de mettre a jour les articles dans un depot
     *
     * @param Bon $livraison La bon de livraison
     * @param Depot $depot Le depot
     * @param array $articles Tableau des articles
     * @return void
     */
    public function updateDepotArticles(Bon $livraison, Depot $depot, array $articles)
    {
        foreach ($articles as $article) {
            DepotArticle::create([
                "article_id" => $article['id'],
                "quantite" => $article['quantite'],
                "responsable" => Auth::user()->id,
                "bon" => $livraison->id,
                "depot_id" => $depot->id,
                "provenance_id" => null,
                "destination_id" => null,
                "date_transaction" => today()->toDateString(),
                "type" => 0,
            ]);
        }
    }
}
