<?php

use App\Http\Controllers\Api\Article\ArticleController;
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

Route::resource('/article', ArticleController::class);


// Authentification fourni par laravel Breeze
Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/connected-user', [UserController::class, 'connectedUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/user', UserController::class);

    Route::post('/auth/logout', [AuthenticatedSessionController::class, 'destroy']);
});
