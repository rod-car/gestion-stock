<?php

namespace App\Http\Controllers\Api\Facturation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Facturation\NouvelleFactureRequest;
use App\Models\Facture\Facture;
use Illuminate\Http\Request;

class FacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Facture::all();
    }


    /**
     * Enregistrer une nouvelle facture
     *
     * @param NouvelleFactureRequest $request
     * @return Response
     */
    public function store(NouvelleFactureRequest $request)
    {
        $data = $request->validated();

        $facture = Facture::create($data);
        return $facture;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        return $facture;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        //
    }

    public function getKey()
    {
        $key = reference(5, null, "FAC");
        return response()->json(["key" => $key]);
    }
}
