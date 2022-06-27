<?php

namespace App\Http\Controllers\Api\Fournisseur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fournisseur\ModifierFournisseurRequest;
use App\Http\Requests\Fournisseur\NouveauFournisseurRequest;
use App\Models\Fournisseur\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fournisseur::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Fournisseur\NouveauFournisseurRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauFournisseurRequest $request)
    {
        $data = $request->validated();
        $categories = $data["categories"];
        unset($data["categories"]);

        $fournisseur = Fournisseur::create($data);

        foreach ($categories as $id) {
            $fournisseur->categories()->attach($id);
        }

        return $fournisseur;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fournisseur\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        return $fournisseur;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Fournisseur\ModifierFournisseurRequest  $request
     * @param  \App\Models\Fournisseur\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierFournisseurRequest $request, Fournisseur $fournisseur)
    {
        $data = $request->validated();
        $categories = $data["categories"];
        unset($data["categories"]);

        $fournisseur->update($data);

        $categoriesActuel = $fournisseur->categories->pluck('id');

        foreach ($categoriesActuel as $id) {
            if (!in_array($id, $categories)) $fournisseur->categories()->detach($id);
        }

        foreach ($categories as $id) {
            if (!$fournisseur->categories->contains($id)) $fournisseur->categories()->attach($id);
        }

        return response()->json(["success" => "Modifié avec succès"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fournisseur\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->categories()->detach();
        $fournisseur->delete();
        return response()->json(["success" => "Supprimé avec succès"]);
    }
}
