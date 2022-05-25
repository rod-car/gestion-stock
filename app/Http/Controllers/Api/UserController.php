<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return User::paginate(5);
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

        $user = User::create($userData);

        $roles = $request->validate([
            'roles' => ["nullable", "array"],
            'roles.*' => ["nullable", "exists:roles,id"]
        ]);

        if (key_exists('roles', $roles))
        {
            foreach ($roles['roles'] as $id) {
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
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $userData = $request->validate([
            'nom_personnel' => ["required", "min:2", "max:255"],
            'prenoms_personnel' => ["required", "min:2", "max:255"],
            'contact_personnel' => ["required"],
            'email' => ["required", "unique:users,email,{$user->id},id", "email", "max:255"],
            'adresse_personnel' => ["required"],
            'cin_personnel' => ["required"],
        ]);

        /*foreach ($user->roles as $role) {
            if (!in_array($role->id, $rolesId)) $user->roles()->detach($role->id);
        }

        $actualRolesId = $user->roles->pluck('id');

        foreach ($rolesId as $id) {
            if (!in_array($id, $actualRolesId)) $user->roles()->attach($id);
        }*/

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
        try {
            $user->delete();

            return response()->json([
                'success' => "Supprimé avec success"
            ]);
        } catch (QueryException $e) {
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
