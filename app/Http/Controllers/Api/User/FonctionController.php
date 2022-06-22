<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\EditFonctionRequest;
use App\Http\Requests\Personnel\NewFonctionRequest;
use App\Models\Personnel\Fonction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if (intval(request()->page) === 0) return Fonction::all();

        return Fonction::paginate();
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(NewFonctionRequest $request)
    {
        $data = $request->validated();

        $permissionsGroups = $data["permissions"];
        $fonctionsEnfantsIds = $data["enfants"];

        $permissions = [];

        // crée les tableau des permissions unique
        foreach ($permissionsGroups as $permissionGroup)
        {
            $permissions = array_unique(array_merge($permissions, $permissionGroup));
        }

        unset($data["permissions"]);
        unset($data["enfants"]);

        $fonction = Fonction::create($data);

        // Inserer les sous fonctions
        foreach ($fonctionsEnfantsIds as $id)
        {
            $fonction->enfants()->attach($id);
        }

        // Ajouter les permissions
        foreach ($permissions as $id)
        {
            $fonction->permissions()->attach($id);
        }

        return $fonction;
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Personnel\Fonction  $fonction
    * @return \Illuminate\Http\Response
    */
    public function show(Fonction $fonction)
    {
        return $fonction;
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Requests\Personnel  $request
    * @param  \App\Models\Personnel\Fonction  $fonction
    * @return \Illuminate\Http\Response
    */
    public function update(EditFonctionRequest $request, Fonction $fonction)
    {
        $data = $request->validated();

        $permissionIds = $data["permissions"];

        unset($data["permissions"]);

        $fonction->update($data);

        foreach ($fonction->permissions as $permission)
        {
            if (!in_array($permission->id, $permissionIds)) $fonction->permissions()->detach($permission->id); // Supprimer les roles qui ne sont plus present
        }

        $actualPermissionIds = $fonction->permissions->pluck('id')->toArray();

        foreach ($permissionIds as $id)
        {
            if (!in_array($id, $actualPermissionIds)) $fonction->permissions()->attach($id); // Ajouter les nouveaux roles
        }

        return response()->json([
            'success' => "Mise a jour avec succèss",
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Personnel\Fonction  $fonction
    * @return \Illuminate\Http\Response
    */
    public function destroy(Fonction $fonction)
    {
        $fonction->permissions()->detach();
        $fonction->personnelles()->detach();
        $fonction->enfants()->detach();
        $fonction->delete();
    }


    /**
    * Retourner tous les persmisisons des fonctions selectionnés
    *
    * @param Request $request Contenant les ids de la fonction
    * @return JsonResponse
    */
    public function permissionsFonctions(Request $request) : JsonResponse
    {
        $fonctionIds = $request->all();
        $permissionIds = [];

        foreach ($fonctionIds as $id)
        {
            $fonction = Fonction::findOrFail($id);
            $permissionIds = array_unique(array_merge($fonction->permissions->pluck('id')->toArray(), $permissionIds));
        }

        return response()->json($permissionIds);
    }


    /**
     * Recuperer les permissions groupé par les fonctions passé dans request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function permissionsGroups(Request $request) : JsonResponse
    {
        $fonctionIds = $request->all();
        $permissionIds = [];

        foreach ($fonctionIds as $id)
        {
            $fonction = Fonction::findOrFail($id);

            foreach ($fonction->enfants as $fonction)
            {
                foreach ($fonction->permissions as $permission)
                {
                    $permissionIds[$fonction->nom_fonction][] = [
                        "description" => $permission->description,
                        "id" => $permission->id,
                    ];
                }
            }

            foreach ($fonction->permissions as $permission)
            {
                $permissionIds[$fonction->nom_fonction][] = [
                    "description" => $permission->description,
                    "id" => $permission->id,
                ];
            }
        }

        return response()->json($permissionIds);
    }
}
