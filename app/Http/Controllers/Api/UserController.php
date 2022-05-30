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
        return User::all();
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
        $userData = $request->validated();
        $roles = $userData['roles'];

        $user = User::create($userData);

        foreach ($roles as $id) {
            $user->roles()->attach($id);
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
        $userData = $request->validated();

        $roles = $userData['roles'];

        // Si l'utilisateur a un compte, on fait ce traitement - Ajouts des roles et verification des roles
        if ($request->hasAccount === true)
        {
            foreach ($user->roles as $role)
            {
                if (!in_array($role->id, $roles)) $user->roles()->detach($role->id); // Supprimer les roles qui ne sont plus present
            }

            $actualRolesId = $user->roles->pluck('id')->toArray();

            foreach ($roles as $id)
            {
                if (!in_array($id, $actualRolesId)) $user->roles()->attach($id); // Ajouter les nouveaux roles
            }
        }
        else
        {   // On remet les informations de compte de l'utilisateur a zero
            $userData['username'] = null;
            $userData['password'] = null;
            $user->roles()->detach();
        }

        $user->update($userData);

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
