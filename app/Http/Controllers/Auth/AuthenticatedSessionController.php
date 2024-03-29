<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use ApiResponser;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Log in the user.
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
     * @return \Illuminate\Http\RedirectResponse
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

        //return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
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
