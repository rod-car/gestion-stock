<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function index()
    {
        $permissions = auth()->user()->roles()->pluck('nom_role');
        
        return $permissions;
    }
}
