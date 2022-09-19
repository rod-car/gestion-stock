<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    use ApiResponser;

    /**
     * Afficher la vue de connexion
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Permet de connecer l'utilisateur
     *
     * @response {
     *  "token": "eyJ0eXA...",
     *  "user": {
     *      id: 1,
     *      .....
     *  },
     *  "success": "Connecté avec success"
     * }
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JSonResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->json([
            'token' => $request->user()->createToken('API Token')->plainTextToken,
            'user' => auth()->user(),
            'success' => "Connecté avec success",
        ]);
    }

    /**
     * Deconnecter l'utilisateur et supprimer la session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        auth()->user()->tokens()->delete();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
