<?php

namespace App\Http\Controllers\Api\Bon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bon\Livraison\ModifierBonLivraisonRequest;
use App\Http\Requests\Bon\Livraison\NouveauBonLivraisonRequest;
use App\Models\Bon\BonLivraison;
use Illuminate\Http\Request;

class BonLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BonLivraison::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Bon\Livraison\NouveauBonLivraisonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauBonLivraisonRequest $request)
    {
        dd($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(BonLivraison $bonLivraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Bon\Livraison\ModifierBonLivraisonRequest  $request
     * @param  \App\Models\Bon\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierBonLivraisonRequest $request, BonLivraison $bonLivraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonLivraison $bonLivraison)
    {
        //
    }
}
