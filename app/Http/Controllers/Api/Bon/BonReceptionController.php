<?php

namespace App\Http\Controllers\Api\Bon;

use Auth;
use Response;
use App\Models\Bon\Bon;
use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Commande;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bon\Reception\ModifierBonReceptionRequest;
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
        return Bon::whereType(1)->get();
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

        //dd($articles);
        $commande = Commande::findOrFail($data['commande']);

        $reception = Bon::create($data);
        $depot = Depot::findOrFail($data['depot']);

        $this->updateArticles($reception, $articles);
        $this->updateCommandeArticles($commande, $articles);
        $this->updateDepotArticles($reception, $depot, $articles);

        return $reception;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon\Bon  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function show(Bon $bonReception)
    {
        return $bonReception;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Bon\Reception\ModifierBonReceptionRequest  $request
     * @param  \App\Models\Bon\Bon  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierBonReceptionRequest $request, Bon $bonReception)
    {
        $bonReception->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon\Bon  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bon $bonReception)
    {
        $bonReception->articles()->detach();
        $bonReception->delete();
    }


    /**
     * Permet de mettre a jour les articles d'un bon de reception
     *
     * @param Bon $reception Bon de reception
     * @param array $articles Tableau contenant les articles
     * @return void
     */
    public function updateArticles(Bon $reception, array $articles)
    {
        foreach ($articles as $article)
        {
            $reception->articles()->attach($article['id'], [
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
            if ($tmp !== null)
            {
                $commande->articles()->updateExistingPivot($article['id'], [
                    'quantite_recu' => $tmp->pivot->quantite_recu + doubleval($article['quantite']),
                ]);
            }
        }
    }

    /**
     * Permet de mettre a jour les articles dans un depot
     *
     * @param Bon $reception La bon de reception
     * @param Depot $depot Le depot
     * @param array $articles Tableau des articles
     * @return void
     */
    public function updateDepotArticles(Bon $reception, Depot $depot, array $articles)
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
