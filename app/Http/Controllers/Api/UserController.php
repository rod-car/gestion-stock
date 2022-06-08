<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\NewUserRequest;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewUserRequest $request)
    {
        $data = $request->validated();
        $fonctions = $data['fonctions'];
        $permissionsGroups = $data['permissions'];

        $permissions = [];

        unset($data['permissions'], $data['fonctions']);

        // crée les tableau des permissions unique
        foreach ($permissionsGroups as $permissionGroup)
        {
            $permissions = array_unique(array_merge($permissions, $permissionGroup));
        }

        // Creation de l'utilisateur dans la BD
        $user = User::create($data);

        // Ajout des fonctions
        foreach ($fonctions as $id) { $user->fonctions()->attach($id); }

        // Ajout des permissions
        if ($request->boolean('hasAccount') AND $request->boolean('hasRole'))
        {
            foreach ($permissions as $id)
            {
                $user->roles()->attach($id);
            }
        }

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->password = "_" . $user->password; // Un tech pour decrypter le mot de passe pour afficher dans le champs
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $user)
    {
        $data = $request->validated();
        $fonctions = $data['fonctions'];
        $permissionsGroups = $data['permissions'];

        unset($data['permissions'], $data['fonctions']);

        $permissions = [];

        // crée les tableau des permissions unique
        foreach ($permissionsGroups as $permissionGroup)
        {
            $permissions = array_unique(array_merge($permissions, $permissionGroup));
        }

        // Si l'utilisateur a un compte, on fait ce traitement - Ajouts des roles et verification des roles
        if ($request->hasAccount === true)
        {
            // Mise a jour des roles
            foreach ($user->roles as $role)
            {
                if (!in_array($role->id, $permissions)) $user->roles()->detach($role->id); // Supprimer les roles qui ne sont plus present
            }

            $actualPermissionsId = $user->roles->pluck('id')->toArray();

            foreach ($permissions as $id)
            {
                if (!in_array($id, $actualPermissionsId)) $user->roles()->attach($id); // Ajouter les nouveaux roles
            }

            // Mise a jour des foncitons
            foreach ($user->fonctions as $fonction) { if (!in_array($fonction->id, $fonctions)) $user->fonctions()->detach($fonction->id); }// Supprimer les roles qui ne sont plus present

            $actualFonctionsId = $user->fonctions->pluck('id')->toArray();

            foreach ($fonctions as $id) { if (!in_array($id, $actualFonctionsId)) $user->fonctions()->attach($id); } // Ajouter les nouveaux roles
        }
        else
        {   // On remet les informations de compte de l'utilisateur a zero
            $data['username'] = null;
            $data['password'] = null;
            $user->roles()->detach();
            $user->fonctions()->detach();
        }

        $user->update($data);

        return response()->json([
            'success' => "Mise a jour avec succèss",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try
        {
            if ($user->id === auth()->user()->id)
            {
                return response()->json([
                    'errors' => "Ne peut pas supprimer l'utilisateur actif"
                ]);
            }
            $user->roles()->detach();
            $user->fonctions()->detach();
            $user->delete();
            return response()->json([
                'success' => "Supprimé avec success"
            ]);
        }
        catch (QueryException $e)
        {
            return response()->json([
                'errors' => "Echec de suppréssion. {$e->getMessage()}"
            ]);
        }
    }

    /**
     * Permet de recuperer l'utilisateur connecté
     *
     * @return void
     */
    public function connectedUser()
    {
        return auth()->user();
    }
}
