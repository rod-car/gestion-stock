<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Models\Categorie\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categorie\ModifierCategorieRequest;
use App\Http\Requests\Categorie\NouveauCategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = intval($request->type);
        $except = intval($request->except); // Identifiant de la catégrie a exclure pour mettre dans sous catégorie
        $onlyParent = boolval($request->appro);

        $categories = Categorie::where('type', $type)->get();

        if($onlyParent){

            $categories = $categories->filter(function($categorie){
                return $categorie->parentCategories->isEmpty();
            });

            $categories = collect($categories->values());

        }


        if ($except > 0) {
            $parents = Categorie::findOrFail($except)->parentCategories->pluck('id');
            $categories = $categories->filter(function ($categorie) use ($parents, $except) {
                return ($parents->contains($categorie->id) === false) and ($categorie->id !== $except);
            });
            $categories = collect($categories->values());
        }
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\NouveauCategorieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauCategorieRequest $request)
    {
        $data = $request->validated();
        $categorie = Categorie::create($data);

        if (key_exists('sous_categories', $data)) {
            foreach ($data['sous_categories'] as $id) {
                $categorie->sousCategories()->attach($id);
            }
        }

        return $categorie;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        return $categorie;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\ModifierCategorieRequest  $request
     * @param  \App\Models\Categorie\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierCategorieRequest $request, Categorie $categorie)
    {
        $data = $request->validated();

        if (key_exists('sous_categories', $data)) {
            foreach ($categorie->sousCategories as $sousCategorie) {
                if (!in_array($categorie->id, $data['sous_categories'])) $categorie->sousCategories()->detach($sousCategorie->id);
            }

            foreach ($data['sous_categories'] as $id) {
                $categorie->sousCategories()->attach($id);
            }
        }

        $categorie->update($data);
        return response()->json(["success" => "Mis a jour avec succès"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->parentCategories()->detach();
        $categorie->sousCategories()->detach();
        $categorie->delete();
        return response()->json(['success' => 'Supprimé avec succes']);
    }


    public function enregistrerCategorieClient()
    {
    }

    public function sousCategorieList(Request $request){
        $parents_id = $request->except ? json_decode($request->except) : [];

        if($parents_id && count($parents_id) > 0){

            $parents = Categorie::whereIn("id", $parents_id)->get();

            $souscategories = collect();

            foreach($parents as $parent){
                if($parent->sousCategories->isNotEmpty()) $souscategories->push($parent->sousCategories);
            }


            return isset($souscategories->unique()[0]) ? $souscategories->unique()[0] : [];
        }

        return [];

    }
}
