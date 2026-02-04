<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CombateController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\EntrenadorController;

Route::get('/pokemons', [PokemonController::class, 'index']);
Route::get('/pokemons{id}', [PokemonController::class, 'show']);
Route::get('/entrenadores/{entrenadorId}', [PokemonController::class, 'porEntrenador']);


Route::get('/entrenadores', [EntrenadorController::class, 'index']);
Route::get('/entrenadores{id}', [EntrenadorController::class, 'show']);


Route::get('/combates', [CombateController::class, 'index']);
Route::get('/combates/{id}', [CombateController::class, 'show']);


Route::post('/entrenadores', [EntrenadorController::class, 'store']);
Route::put('/entrenadores/{id}', [EntrenadorController::class, 'update']);
Route::delete('/entrenadores/{id}', [EntrenadorController::class, 'destroy']);

// Jugadores - CRUD completo (solo admin)
Route::post('/pokemons', [PokemonController::class, 'store']);
Route::put('/pokemons/{id}', [PokemonController::class, 'update']);
Route::delete('/pokemons/{id}', [PokemonController::class, 'destroy']);


Route::post('/combates', [CombateController::class, 'store']);
Route::put('/combates/{id}', [CombateController::class, 'update']);
Route::delete('/combates/{id}', [CombateController::class, 'destroy']);

