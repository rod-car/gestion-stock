<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return User::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rolesId = [];
        $userData = [];

        if (count($request->all()) === 2)
        {
            $userData = $request->all()['user'];
            $rolesId = $request->all()['roles'];
        }
        else
        {
            $userData = $request->all();
        }

        $user = User::create($userData);

        foreach ($rolesId as $id)
        {
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
        $rolesId = [];
        $userData = [];

        if (count($request->all()) === 2) {
            $userData = $request->all()['user'];
            $rolesId = $request->all()['roles'];
        } else {
            $userData = $request->all();
        }

        foreach ($user->roles as $role) {
            if (!in_array($role->id, $rolesId)) $user->roles()->detach($role->id);
        }

        $actualRolesId = $user->roles->pluck('id');

        foreach ($rolesId as $id) {
            if (!in_array($id, $actualRolesId)) $user->roles()->attach($id);
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
