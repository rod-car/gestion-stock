<?php

namespace App\Http\Controllers\Api\Depot;

use App\Http\Controllers\Controller;
use App\Http\Requests\Depot\ModifierDepotRequest;
use App\Http\Requests\Depot\NouveauDepotRequest;
use App\Models\Depot\Depot;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $point_vente = boolval($request->type);

        return Depot::where('point_vente', $point_vente)->get();
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
     * Display the specified resource.
     *
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function show(Depot $depot)
    {
        return $depot;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Depot\ModifierDepotRequest  $request
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierDepotRequest $request, Depot $depot)
    {
        $data = $request->validated();
        $depot->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depot\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depot $depot)
    {
        $depot->delete();
        return response()->json(['success' => 'Supprimé avec succes']);
    }
}
