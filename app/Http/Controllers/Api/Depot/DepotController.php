<?php

namespace App\Http\Controllers\Api\Depot;

use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use Illuminate\Support\Facades\Auth;
use App\Models\Depot\DepotPrixArticle;
use App\Http\Requests\Depot\NouveauDepotRequest;
use App\Http\Requests\Depot\ModifierDepotRequest;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queries = $request->query(); // Si on fait un recherche des dépots

        if (count($queries) > 0 AND !key_exists('type', $queries))
        {
            $depots = new Depot();

            foreach ($queries as $key => $value)
            {
                $depots = $depots->where($key, 'LIKE', "%$value%");
            }

            return $depots->where("disabled", false)->get();
        }


        return Depot::where("disabled", false)->when($request->type != 3, function($q) use ($request){
            return $q->where('point_vente', boolval($request->type));
        })->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Depot\NouveauDepotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauDepotRequest $request)
    {
        $data = $request->validated();
        $depot = Depot::create($data);
        return $depot;
    }


    /**
     * Voir un dépot spécifique
     *
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function show(Depot $depot)
    {
        return $depot;
    }


    /**
     * Mettre a jour un depot
     *
     * @param  \Illuminate\Http\Depot\ModifierDepotRequest  $request
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierDepotRequest $request, Depot $depot)
    {
        $data = $request->validated();
        $updateType = $data["type"];

        // Si c'est une mise a jour complet (Personnel, responsable, depot lui-même)
        if ($updateType === 0) {
            $data = $this->updatePersonnelle($depot, $data);
            $data = $this->updateResponsable($depot, $data);
            $depot->update($data);
        }

        // Si c'est une mise a jour des responsables seulement
        if ($updateType === 1) {
            $data = $this->updateResponsable($depot, $data);
        }

        // Si c'est une mise a jour des personnelles seulement
        if ($updateType === 2) {
            $data = $this->updatePersonnelle($depot, $data);
        }

        // Si c'est une mise a jour du depot lui-même
        if ($updateType === 3) {
            $depot->update($data);
        }

        return response()->json(["success" => "Mis a jour avec succès"]);
    }

    /**
     * Supprimer un dépot
     *
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depot $depot)
    {

        if($depot->articles->isEmpty()){

            $depot->responsables()->detach();
            $depot->travailleurs()->detach();
            $depot->delete();
        }else{

            $is_empty = true;

            foreach ($depot->articles as $key => $article) {
                if(doubleval($depot->articleStock($article->id)) > 0) $is_empty = false;
            }

            if(!$is_empty) return response(["error" => "Le point de vent n'est pas vide"], 500);
            else {
                $depot->disabled = true;
                $depot->update();
            };
        }

        return response()->json(['success' => 'Supprimé avec succes']);
    }


    /**
     * Permet de mettre a jour uniquement les responsable du depot
     *
     * @param array $data
     * @return array
     */
    private function updateResponsable(Depot $depot, array $data): array
    {
        $responsablesId = $data['responsables']; // L'IDs des responsables provenant du formulaire
        $responsablesIdActuel = $depot->responsables->pluck('id')->toArray(); // Tous les responsables actuel

        foreach ($responsablesIdActuel as $id) {
            // Supprimer la responsable qui n'est plus présent dans la formulaire
            if (!in_array($id, $responsablesId)) $depot->responsables()->updateExistingPivot($id, [
                'est_responsable' => false,
            ]);
        }

        // Enregistre ou mettre a jours les noveau responsables ou les mettre a jour s'ils sont deja responsable
        foreach ($responsablesId as $id) {
            if (!$depot->travailleurs->contains($id)) {
                $depot->responsables()->attach($id, [
                    "est_responsable" => true,
                ]);
            } else {
                $depot->travailleurs()->updateExistingPivot($id, [
                    'est_responsable' => true,
                ]);
            }
        }

        unset($data['responsables']);
        return $data;
    }


    /**
     * Mettre a jour uniquement les personnelles (responsable inclus)
     *
     * @param Depot $depot
     * @param array $data
     * @return array
     */
    private function updatePersonnelle(Depot $depot, array $data): array
    {
        $travailleursId = $data['travailleurs']; // L'IDs des personnelles provenant du formulaire
        $travailleursIdActuel = $depot->travailleurs->pluck('id')->toArray(); // Tous les travailleurs actuel (Responsable inclus)

        foreach ($travailleursIdActuel as $id) {
            // Supprimer le personnel qui ne travaille plus dans le point de vente
            if (!in_array($id, $travailleursId)) $depot->travailleurs()->detach($id);
        }

        // Enregistre ou mettre a jours les noveau travailleurs
        foreach ($travailleursId as $id) {
            if (!$depot->travailleurs->contains($id)) {
                $depot->travailleurs()->attach($id);
            }
        }

        unset($data['travailleurs']);
        return $data;
    }


    /**
     * Permet de verifier le prix unitaire de l'article
     *
     * @param array $articles
     * @return boolean
     */
    public function checkPU(array $articles): bool
    {
        $pus = [];
        foreach ($articles as $article)
        {
            $pus[] = doubleval($article['pu']);
        }
        if (count(array_unique($pus)) === 1 AND count($articles) > 1) return false;
        return true;
    }


    /**
     * Permet de gerer le prix dans un depot
     *
     * @param Depot $depot Depot en question
     * @param Article $article L'article en question
     * @param Request $request
     * @return void
     */
    public function gererPrixArticle(Depot $depot, Article $article, Request $request)
    {
        $data = $request->validate([
            "articles" => ["required", "array"],
            "articles.*.reference" => ['required', 'exists:articles,reference'],
            "articles.*.designation" => ['required', 'exists:articles,designation'],
            "articles.*.quantite" => ['nullable', 'numeric', 'min:1', 'max:999999999999'],
            "articles.*.pu" => ['required', 'numeric', 'min:1', 'max:999999999999'],
        ]);

        // $exists = DepotArticle::whereDepotId($depot->id)->whereArticleId($article->id)->first() !== null;

        if ($this->checkPU($data['articles']) === false) return response(['message' =>'Les prix sont identiques'], 422);

        foreach ($data['articles'] as $a)
        {

            $nouveauPrix = DepotPrixArticle::create([
                                'article' => $article->id,
                                'depot' => $depot->id,
                                'quantite' => $a['quantite'] === null ? null : doubleval($a['quantite']),
                                'pu' => doubleval($a['pu']),
                            ]);

            if ($a['quantite'] === null) {

                DepotArticle::create([
                    "article_id" => $article->id,
                    "quantite" => 0,
                    "responsable" => Auth::user()->id,
                    "bon" => null,
                    "depot_id" => $depot->id,
                    "provenance_id" => null,
                    "destination_id" => null,
                    "date_transaction" => today()->toDateString(),
                    "type" => 1,
                ]);

                DepotPrixArticle::where("id", "!=", $nouveauPrix->id)
                                ->whereArticle($article->id)
                                ->whereDepot($depot->id)
                                ->whereQuantite(null)
                                ->delete();
            }
        }

        return response()->json([
            'success' => 'Success'
        ]);
    }
}
