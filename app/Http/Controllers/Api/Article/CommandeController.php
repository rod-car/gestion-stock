<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commande\ModifierCommandeRequest;
use App\Http\Requests\Commande\NouveauCommandeRequest;
use App\Models\Article\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Commande::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Commande\NouveauCommandeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauCommandeRequest $request)
    {
        return $request->validated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
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
        //
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
}
