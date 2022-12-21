<?php

namespace App\Http\Controllers\Api\Article;

use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Models\Article\Transfert;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use App\Http\Requests\Transfert\NouveauTransfertRequest;
use App\Models\Depot\DepotPrixArticle;

class TransfertController extends Controller
{

    public function store(NouveauTransfertRequest $request) {

        $articles = $request->all(['articles']);

        //dd($articles);
        $depots = $request->all(["depotOrigin", "depotDestiny"]);

        $transfert = Transfert::create($request->all(['numero', 'date']));

        foreach ($articles["articles"] as $key => $article) {
            # code...
            $quantites = 0;

            foreach ($article["quantite"] as $key_quantite => $quantite) {
                # code...
                $quantites += floatval($quantite) ;

                if($key_quantite > 0 && floatval($quantite) > 0) {
                    // mise à jour de la quantité par prix de l'origin et ajout de celle du destination
                    $depotPrixOrigin =  DepotPrixArticle::find($key_quantite);


                    $depotPrixDestiny = $depotPrixOrigin->replicate();
                    $depotPrixDestiny->quantite = $quantite;

                    $isPriceExist = DepotPrixArticle::where("depot", $depots['depotDestiny'])
                                    ->where("pu", floatval($depotPrixOrigin->pu))
                                    ->where("article", $depotPrixOrigin->article)
                                    ->get();

                    if(isset($isPriceExist[0]) && isset($isPriceExist->quantite)) {
                        $depotPrixDestiny = $isPriceExist[0];
                        $depotPrixDestiny->quantite = floatval($depotPrixDestiny->quantite) + $quantite;
                    }

                    $depotPrixDestiny->depot = $depots["depotDestiny"];
                    $depotPrixDestiny->save();

                    $depotPrixOrigin->quantite = floatval($depotPrixOrigin->quantite) -  $quantite;

                    $depotPrixOrigin->save();

                }
            }

            if(floatval($quantites)){

                $depotArticles = [
                    "article_id" => $article["id"],
                    "transfert_id" => $transfert->id,
                    "quantite" => $quantites
                ];

                DepotArticle::createDepotAritcle(
                    $depotArticles +
                    [
                        "depot_id" => $depots["depotOrigin"],
                        "depotDestiny" => $depots["depotOrigin"],
                    ]
                );

                DepotArticle::createDepotAritcle(
                        $depotArticles +[
                                    "depot_id" => $depots["depotDestiny"],
                                    "depotDestiny" => $depots["depotDestiny"],
                                ]
                        ,
                        1

                );
            }


        }

        return $transfert;
    }

    public function index(){
        return Transfert::all();
    }

    public function show($transfert){
        $res = Transfert::with(['articles'])->where("transferts.id", $transfert)->get();
         return $res->isEmpty() ? [] : $res[0];
    }
}
