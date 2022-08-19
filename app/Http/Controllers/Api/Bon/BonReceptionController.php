<?php

namespace App\Http\Controllers\Api\Bon;

use Auth;
use Response;
use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Commande;
use App\Models\Bon\BonReception;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use App\Http\Requests\Bon\Reception\NouveauBonReceptionRequest;

class BonReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BonReception::all();
    }


    /**
     * Creer un nouveau ressource dans la base de données
     *
     * @param NouveauBonReceptionRequest $request
     * @return Response
     */
    public function store(NouveauBonReceptionRequest $request)
    {
        $data = $request->validated();
        $articles = $data["articles"];
        unset($data["articles"]);

        $commande = Commande::findOrFail($data['commande']);
        $reception = BonReception::create($data);
        $depot = Depot::findOrFail($data['depot']);

        $this->updateArticles($reception, $articles);
        $this->updateCommandeArticles($commande, $articles);
        $this->updateDepotArticles($reception, $depot, $articles);

        return $reception;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon\BonReception  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function show(BonReception $bonReception)
    {
        return $bonReception;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bon\BonReception  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonReception $bonReception)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon\BonReception  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonReception $bonReception)
    {
        //
    }


    public function updateArticles(BonReception $reception, array $articles)
    {
        foreach ($articles as $article)
        {
            $reception->articles()->attach($article['id'], [
                "quantite" => abs($article["quantite"])
            ]);
        }
    }


    public function updateCommandeArticles(Commande $commande, array $articles)
    {
        foreach ($articles as $article) {
            $tmp = $commande->articles()->wherePivot('article', $article['id'])->first();
            if ($tmp !== null)
            {
                $commande->articles()->updateExistingPivot($article['id'], [
                    'quantite_recu' => $tmp->pivot->quantite_recu + doubleval($article['quantite']),
                ]);
            }
        }
    }

    public function updateDepotArticles(BonReception $reception, Depot $depot, array $articles)
    {
        foreach ($articles as $article)
        {
            DepotArticle::create([
                "article_id" => $article['id'],
                "quantite" => $article['quantite'],
                "responsable" => Auth::user()->id,
                "bon" => $reception->id,
                "depot_id" => $depot->id,
                "provenance_id" => null,
                "destination_id" => null,
                "date_transaction" => today()->toDateString(),
                "type" => 1,
            ]);
        }
    }
}
