<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{
    public function index():JsonResponse
    {
        $pokemons = Pokemon::with('entrenador')->get();

        return response()->json([
            'success'=> true,
            'data'=>$pokemons,
            'message'=>'Listado de pokemons obtenido correctamente'
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $pokemon = Pokemon::with('entrenador')->find($id);

        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokemon no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pokemon,
            'message' => 'Pokemon obtenido correctamente'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'nivel' => 'required|integer|min:1|max:100',
            'entrenador_id' => 'required|exists:entrenadores,id',
        ]);

        $pokemon = Pokemon::create($validated);
        $pokemon->load('entrenador');

        return response()->json([
            'success' => true,
            'data' => $pokemon,
            'message' => 'Pokemon creado correctamente'
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokemon no encontrado'
            ], 404);
        }

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|string|max:100',
            'nivel' => 'sometimes|required|integer|min:1|max:100',
            'entrenador_id' => 'sometimes|required|exists:entrenadores,id',
        ]);

        $pokemon->update($validated);
        $pokemon->load('entrenador');

        return response()->json([
            'success' => true,
            'data' => $pokemon,
            'message' => 'Pokemon actualizado correctamente'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokemon no encontrado'
            ], 404);
        }

        $pokemon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pokemon eliminado correctamente'
        ]);
    }

    public function porEntrenador(int $entrenadorId): JsonResponse
    {
        $pokemons = Pokemon::where('entrenador_id', $entrenadorId)->with('entrenador')->get();

        return response()->json([
            'success' => true,
            'data' => $pokemons,
            'message' => 'Pokemons del entrenador obtenidos correctamente'
        ]);
    }
}
