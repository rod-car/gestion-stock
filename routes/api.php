<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\Depot\DepotController;
use App\Http\Controllers\Api\User\AbilityController;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\User\FonctionController;
use App\Http\Controllers\Api\Article\ArticleController;
use App\Http\Controllers\Api\Article\CommandeController;
use App\Http\Controllers\Api\Bon\BonReceptionController;
use App\Http\Controllers\Api\Client\CategorieController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Fournisseur\FournisseurController;
use App\Http\Controllers\Api\Parametres\ParametreGeneraleController;

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


    // ----------------------------------------------------------- Gestion de dépot (Entrepot / Point de vente) ----------------------------------------------------------------------

    // Permet de recuperer les articles dans un depot en particulier
    Route::get('/depot/{depot}/articles', [ArticleController::class, 'articles']);

    // Permet de recuperer les articles dans un depot en particulier
    Route::post('/depot/{depot}/gerer-prix/{article}', [DepotController::class, 'gererPrixArticle']);

    // Route pour la gestion de point de vente
    Route::apiResource('/depot', DepotController::class);

    // ----------------------------------------------------------- Fin gestion de dépot ----------------------------------------------------------------------


    // Gerer tous les catégories (Articles, Client, Fournisseur)
    Route::apiResource('/categorie', CategorieController::class);

    // Gerer tous les CRUD fournisseurs
    Route::apiResource('/fournisseur', FournisseurController::class);

    // Gerer tous les CRUD fournisseurs
    Route::apiResource('/client', ClientController::class);

    // Ressource qui gere les CRUD de l'article
    Route::apiResource('/article', ArticleController::class);

    // Recupere le nouveau numéro du dévis ou commande et l'afficher au client
    Route::get('/commandes/get-key', [CommandeController::class, 'getKey']);

    // Ressource qui gere les CRUD des commande et devis
    Route::apiResource('/commandes', CommandeController::class);

    // Ressource qui gere les CRUD des bos de reception
    Route::apiResource('/bon-receptions', BonReceptionController::class);

    // Gestion des paramètres
    Route::get('/parametres/generale', [ParametreGeneraleController::class, 'index']);
    Route::post('/parametres/generale', [ParametreGeneraleController::class, 'store']);
    Route::patch('/parametres/generale/{parametre}', [ParametreGeneraleController::class, 'update']);

});
