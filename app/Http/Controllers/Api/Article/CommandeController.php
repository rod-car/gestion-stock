<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commande\ModifierCommandeRequest;
use App\Http\Requests\Commande\NouveauCommandeRequest;
use App\Models\Article\Commande;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = intval($request->type);
        return Commande::where('type', $type)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Commande\NouveauCommandeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauCommandeRequest $request)
    {
        $data = $request->validated();
        $articles = $data['articles'];
        $commande = Commande::create($data);

        $this->updateArticle($commande, $articles);

        return $commande;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        return $commande;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Commande\ModifierCommandeRequest  $request
     * @param  \App\Models\Article\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierCommandeRequest $request, Commande $commande)
    {
        $data = $request->validated();
        $articles = $data['articles'];
        $commande->update($data);

        $this->updateArticle($commande, $articles);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }


    /**
     * Mettre a jour les articles associé a un commande
     *
     * @param Commande $commande La commande en question
     * @param array $articles Les articles concerné
     * @return bool
     */
    public function updateArticle(Commande $commande, array $articles): bool
    {
        $articlesActuel = $commande->articles->pluck('id')->toArray();

        foreach ($articlesActuel as $id) {
            if (!in_array($id, collect($articles)->pluck('id')->toArray())) {
                $commande->articles()->detach($id);
            }
        }

        foreach ($articles as $article) {
            if ($commande->articles->contains($article["id"])) {
                $commande->articles()->updateExistingPivot($article["id"], [
                    'pu' => $article['pu'],
                    'quantite' => $article['quantite'],
                    'tva' => $article['tva'],
                ]);
            } else {
                $commande->articles()->attach($article['id'], [
                    'pu' => $article['pu'],
                    'quantite' => $article['quantite'],
                    'tva' => $article['tva'],
                ]);
            }
        }

        return true;
    }


    /**
     * Recuperer le dernier dernier devis
     *
     * @param Request $request
     * @return Response
     */
    public function getKey(Request $request)
    {
        if (intval($request->type) === 1) {
            return response()->json([
                "key" => numeroDevis(),
            ]);
        }

        return null;
    }
}
