<?php

namespace App\Http\Controllers\Api\Article;

use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Models\Article\Transfert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfert\ModifierTransfertRequest;
use App\Models\Article\DepotArticle;
use App\Http\Requests\Transfert\NouveauTransfertRequest;
use App\Models\Depot\DepotPrixArticle;

class TransfertController extends Controller
{

    public function store(NouveauTransfertRequest $request) {

        $articles = $request->all(['articles']);

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

    public function equilivreQuantitePrix($article_id, $quantityArticlePriceToReduces, $reduce, $rise){

        $quantityArticlePriceToReduce = $quantityArticlePriceToReduces;
        // reduire ou augementer la quantité des articles avec prix car les sans prix ne suffisent pas
        $articleWithPrice = DepotPrixArticle::where("depot", $reduce)->where("article", $article_id)->get();
        foreach ($articleWithPrice as $key => $articleWP) {
            # code...
            if(floatval($articleWP->quantite)){

                //on deduit la quantite avec prix parcouru
                $resQuantite = floatval($articleWP->quantite) - $quantityArticlePriceToReduce;
                $articleWP->quantite = ($resQuantite > 0) ? $resQuantite : 0;
                $articleWP->save();
                // si c'est negatif alors il y a encore de quantité restant
                if ($resQuantite < 0 ) $quantityArticlePriceToReduce = abs($resQuantite);
                else $quantityArticlePriceToReduce = 0;

            }
        }


        // $articleWithPrice = DepotPrixArticle::where("depot", $rise)->where("article", $article_id)->get();

        // if (isset($articleWithPrice[0])) {
        //     $articleWithPrice[0]->quantite = floatval($articleWithPrice[0]->quantite) + $quantityArticlePriceToReduces;
        //     $articleWithPrice[0]->save();
        // }


    }

    public function update(ModifierTransfertRequest $request,  $transfert_id){

        $transfert = Transfert::find($transfert_id);
        if($transfert->count() > 0){
            foreach ($request->articles as $key => $article) {
                # code...

                $transfertArticleQuantiteOld = $transfert->articleQuantite($article["id"]);

                $diff = floatval($transfertArticleQuantiteOld) - floatVal($article["quantite"][0]);


                if($diff > 0){
                    // la quantité a diminué
                    $globalDepotArticleWithPrice = DepotPrixArticle::depotArticlePrixSum($request->depotDestiny, $article["id"]);

                    $depotArticleQuantiteOld = Depot::find($request->depotDestiny)->articleStock($article["id"]);

                    $totalNotWithPrice = floatval($depotArticleQuantiteOld) - floatval($globalDepotArticleWithPrice);

                    $quantityArticlePriceToReduces = abs($diff) - $totalNotWithPrice;
                    if($quantityArticlePriceToReduces > 0){
                        $this->equilivreQuantitePrix($article["id"], $quantityArticlePriceToReduces, $request->depotDestiny, $request->depotOrigin);
                    }

                }else{


                    $globalDepotArticleWithPrice = DepotPrixArticle::depotArticlePrixSum($request->depotOrigin, $article["id"]);

                    $depotArticleQuantiteOld = Depot::find($request->depotOrigin)->articleStock($article["id"]);

                    $totalNotWithPrice = floatval($depotArticleQuantiteOld) - floatval($globalDepotArticleWithPrice);

                    $quantityArticlePriceToReduces = abs($diff) - $totalNotWithPrice;

                    if ($quantityArticlePriceToReduces > 0) {
                        $this->equilivreQuantitePrix($article["id"], $quantityArticlePriceToReduces,$request->depotOrigin, $request->depotDestiny);
                    }
                }

                DepotArticle::where("transfert_id", $transfert->id)->delete();

                $depotArticles = [
                    "article_id" => $article["id"],
                    "transfert_id" => $transfert->id,
                    "quantite" => $article["quantite"][0]
                ];



                DepotArticle::createDepotAritcle(
                    $depotArticles +
                    [
                        "depot_id" => $request->depotOrigin,
                        "depotDestiny" => $request->depotOrigin,
                        ]
                    );

                DepotArticle::createDepotAritcle(
                    $depotArticles + [
                        "depot_id" => $request->depotDestiny,
                        "depotDestiny" => $request->depotDestiny,
                    ],
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

    public function destroy(){

    }
}
