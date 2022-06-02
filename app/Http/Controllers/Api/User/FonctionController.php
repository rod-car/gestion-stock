<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\EditFonctionRequest;
use App\Http\Requests\Personnel\NewFonctionRequest;
use App\Models\Personnel\Fonction;
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

        $permissionIds = $data["permissions"];

        unset($data["permissions"]);

        $fonction = Fonction::create($data);

        foreach ($permissionIds as $permissionId)
        {
            $fonction->permissions()->attach($permissionId);
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
        $fonction['permissionsId'] = $fonction->permissions->pluck('id')->toArray();
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
        $fonction->permissions()->delete();
        $fonction->personnelles()->delete();
        $fonction->delete();
    }
}
