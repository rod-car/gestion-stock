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
        $updateType = $data["type"];

        if ($updateType === 0) {
            $data = $this->updatePersonnelle($depot, $data);
            $data = $this->updateResponsable($depot, $data);
            $depot->update($data);
        }

        if ($updateType === 1) {
            $data = $this->updateResponsable($depot, $data);
        }

        if ($updateType === 2) {
            $data = $this->updatePersonnelle($depot, $data);
        }

        if ($updateType === 3) {
            $depot->update($data);
        }

        return response()->json(["success" => "Mis a jour avec succès"]);
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
}
