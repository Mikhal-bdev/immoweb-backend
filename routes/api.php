<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TypeUserController;
use App\Http\Controllers\Api\PrivilegeController;
use App\Http\Controllers\Api\AgenceController;
use App\Http\Controllers\Api\TypebienController;
use App\Http\Controllers\Api\BienController;
use App\Http\Controllers\Api\PayssController;
use App\Http\Controllers\Api\DepartementController;
use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\VilleController;
use App\Http\Controllers\Api\ArrondissementController;
use App\Http\Controllers\Api\QuartierController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route pour obtenir l'utilisateur authentifié (si nécessaire)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Définition des ressources API avec le FQCN
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
Route::resource('typeusers', TypeUserController::class, ['except' => ['create', 'edit']]);
Route::resource('privileges', PrivilegeController::class, ['except' => ['create', 'edit']]);
Route::resource('agences', AgenceController::class, ['except' => ['create', 'edit']]);

Route::resource('typebiens', TypebienController::class, ['except' => ['create', 'edit']]);
Route::resource('biens', BienController::class, ['except' => ['create', 'edit']]);
Route::resource('payss', PayssController::class, ['except' => ['create', 'edit']]);
Route::resource('departements', DepartementController::class, ['except' => ['create', 'edit']]);
Route::resource('communes', CommuneController::class, ['except' => ['create', 'edit']]);
Route::resource('villes', VilleController::class, ['except' => ['create', 'edit']]);
Route::resource('arrondissements', ArrondissementController::class, ['except' => ['create', 'edit']]);
Route::resource('quartiers', QuartierController::class, ['except' => ['create', 'edit']]);
Route::get('/', [HomeController::class, 'index']); // Page d'accueil
Route::get('/search', [HomeController::class, 'search']); // Recherche avancée