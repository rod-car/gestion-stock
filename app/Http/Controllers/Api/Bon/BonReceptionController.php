<?php

namespace App\Http\Controllers\Api\Bon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bon\Reception\NouveauBonReceptionRequest;
use App\Models\Bon\BonReception;
use Illuminate\Http\Request;
use Response;

class BonReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        dd($data);

        $reception = BonReception::create($data);
        $this->updateArticles($reception, $articles);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon\BonReception  $bonReception
     * @return \Illuminate\Http\Response
     */
    public function show(BonReception $bonReception)
    {
        //
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
}
