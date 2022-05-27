<?php

namespace App\Http\Controllers\Api\Role;

use App\Models\Role\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (intval(request()->perPage) > 0) {
            return Role::paginate(intval(request()->perPage));
        }
        return Role::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_role' => ["required", "min:2", "max:255", "unique:roles,nom_role"]
        ], [
            'nom_role.required' => "Le nom de rôle est eréquis",
            'nom_role.min' => "Le nom doit être au moins :min caractère (s)",
            'nom_role.max' => "Le nom de rôle ne doit pas depasse :max caractère (s)",
            'nom_role.unique' => "Le nom de rôle éxiste déja",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => "Les champs ne sont pas bien remplis"
            ], 422);
            dd(false);
        }

        return Role::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $update = $role->update($request->all());
        if ($update) {
            return response()->json([
                'success' => "Modifié avec success",
            ]);
        } else {
            return response()->json([
                'errors' => "Erreur de modification",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try
        {
            $role->delete();
            return response()->json([
                'success' => "Supprimé avec success",
            ]);
        }
        catch (Exception $e)
        {
            return response()->json([
                'errors' => "Erreur de suppression",
            ]);
        }
    }


    /**
     * Permet de rechercher un role en particulier en fonction de la recherche
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $perPage = intval(request()->perPage);
        $query = Role::where("nom_role", "LIKE", "%{$request->q}%");

        if ($perPage > 0) return $query->paginate($perPage);
        return $query->paginate();
    }
}
