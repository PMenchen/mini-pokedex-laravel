<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CombateController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\EntrenadorController;

/*
|--------------------------------------------------------------------------
| Rutas de la API - Mini Pokedex
|--------------------------------------------------------------------------
|
| Aqui se definen todas las rutas de la API REST para gestionar
| entrenadores, Pokemon y combates.
|
| Prefijo: /api (configurado automaticamente por Laravel)
|
*/

// ============================================================================
// RUTAS DE POKEMON
// ============================================================================

// GET /api/pokemons - Obtener todos los Pokemon
Route::get('/pokemons', [PokemonController::class, 'index']);

// GET /api/pokemons/{id} - Obtener un Pokemon por ID
Route::get('/pokemons/{id}', [PokemonController::class, 'show']);

// POST /api/pokemons - Crear un nuevo Pokemon
Route::post('/pokemons', [PokemonController::class, 'store']);

// PUT /api/pokemons/{id} - Actualizar un Pokemon existente
Route::put('/pokemons/{id}', [PokemonController::class, 'update']);

// DELETE /api/pokemons/{id} - Eliminar un Pokemon
Route::delete('/pokemons/{id}', [PokemonController::class, 'destroy']);

// ============================================================================
// RUTAS DE ENTRENADORES
// ============================================================================

// GET /api/entrenadores - Obtener todos los entrenadores
Route::get('/entrenadores', [EntrenadorController::class, 'index']);

// GET /api/entrenadores/{id} - Obtener un entrenador por ID
Route::get('/entrenadores/{id}', [EntrenadorController::class, 'show']);

// GET /api/entrenadores/{entrenadorId}/pokemons - Obtener Pokemon de un entrenador
Route::get('/entrenadores/{entrenadorId}/pokemons', [PokemonController::class, 'porEntrenador']);

// POST /api/entrenadores - Crear un nuevo entrenador
Route::post('/entrenadores', [EntrenadorController::class, 'store']);

// PUT /api/entrenadores/{id} - Actualizar un entrenador existente
Route::put('/entrenadores/{id}', [EntrenadorController::class, 'update']);

// DELETE /api/entrenadores/{id} - Eliminar un entrenador
Route::delete('/entrenadores/{id}', [EntrenadorController::class, 'destroy']);

// ============================================================================
// RUTAS DE COMBATES
// ============================================================================

// GET /api/combates - Obtener todos los combates
Route::get('/combates', [CombateController::class, 'index']);

// GET /api/combates/{id} - Obtener un combate por ID
Route::get('/combates/{id}', [CombateController::class, 'show']);

// POST /api/combates - Crear un nuevo combate
Route::post('/combates', [CombateController::class, 'store']);

// PUT /api/combates/{id} - Actualizar un combate existente
Route::put('/combates/{id}', [CombateController::class, 'update']);

// DELETE /api/combates/{id} - Eliminar un combate
Route::delete('/combates/{id}', [CombateController::class, 'destroy']);
