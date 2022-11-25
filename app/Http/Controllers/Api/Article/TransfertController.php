<?php

namespace App\Http\Controllers\Api\Article;

use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfert\NouveauTransfertRequest;
use App\Models\Article\DepotArticle;

class TransfertController extends Controller
{

    public function store(NouveauTransfertRequest $request) {
        dd($request->articles[0]['id'], $request->depotOrigin ,DepotArticle::getDepotArticles(Depot::findOrFail($request->depotOrigin))->get()->where('article_id', $request->articles[0]['id'])->first());

    }
}
