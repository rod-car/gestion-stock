<?php

use App\Http\Controllers\Api\Article\ArticleController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\AbilityController;
use App\Http\Controllers\Api\User\FonctionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ressource qui gere la gestion des articles
Route::apiResource('/article', ArticleController::class);


// Authentification fourni par laravel Breeze
Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    // Recuperer l'utilisateur connecté
    Route::get('/connected-user', [UserController::class, 'connectedUser']);

    // Ressource pour le CRUD de l'utilisateur
    Route::apiResource('/user', UserController::class);

    // Permet de deconnecter un utilisateur
    Route::post('/auth/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Recuperer toutes les permissions de l'utilisateur
    Route::get('/abilities', [AbilityController::class, 'index']);

    // Endpoint pour rechercher un role
    Route::get('/roles/search', [RoleController::class, 'search']);

    // Ressource qui gere la gestion des roles
    Route::apiResource('/roles', RoleController::class);

    // Permet de gere le CRUD de la fonction
    Route::apiResource('/fonctions', FonctionController::class);

    // Recuperer les permissions associe a des ID
    Route::get('/permissions-fonction', [FonctionController::class, 'permissionsFonctions']);

    // Recuperer les permissions groupé par fonction
    Route::get('/permissions-groups', [FonctionController::class, 'permissionsGroups']);

});
