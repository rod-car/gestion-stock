<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Role\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user)
        {
            $roles = Role::all()->pluck('nom_role')->toArray();

            foreach ($roles as $role)
            {
                Gate::define($role, function (User $user) use ($role) {
                    return in_array($role, $user->roles->pluck('nom_role')->toArray());
                });
            }
        }

        return $next($request);
    }
}
