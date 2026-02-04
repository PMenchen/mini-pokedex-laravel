<?php

namespace App\Http\Controllers;

use App\Models\Combate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CombateController extends Controller
{
    public function index(): JsonResponse
    {
        $combates = Combate::with(['pokemonLocal', 'pokemonVisitante'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $combates,
            'message' => 'Listado de combates obtenido correctamente'
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $combate = Combate::with(['pokemonLocal', 'pokemonVisitante'])->find($id);

        if (!$combate) {
            return response()->json([
                'success' => false,
                'message' => 'Combate no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $combate,
            'message' => 'Combate obtenido correctamente'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Validación de datos
        $validated = $request->validate([
            'pokemon_local_id' => 'required|exists:pokemons,id',
            'pokemon_visitante_id' => 'required|exists:pokemons,id|different:pokemon_local_id',
            'fecha' => 'required|date',
            'resultado' => 'nullable|string|regex:/^\d+-\d+$/',
        ]);

        $combate = Combate::create($validated);
        $combate->load(['pokemonLocal', 'pokemonVisitante']);

        return response()->json([
            'success' => true,
            'data' => $combate,
            'message' => 'Combate creado correctamente'
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $combate = Combate::find($id);

        if (!$combate) {
            return response()->json([
                'success' => false,
                'message' => 'Combate no encontrado'
            ], 404);
        }

        // Validación de datos
        $validated = $request->validate([
            'pokemon_local_id' => 'sometimes|required|exists:pokemons,id',
            'pokemon_visitante_id' => 'sometimes|required|exists:pokemons,id',
            'fecha' => 'sometimes|required|date',
            'resultado' => 'nullable|string|regex:/^\d+-\d+$/',
        ]);

        $combate->update($validated);
        $combate->load(['pokemonLocal', 'pokemonVisitante']);

        return response()->json([
            'success' => true,
            'data' => $combate,
            'message' => 'Combate actualizado correctamente'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $combate = Combate::find($id);

        if (!$combate) {
            return response()->json([
                'success' => false,
                'message' => 'Combate no encontrado'
            ], 404);
        }

        $combate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Combate eliminado correctamente'
        ]);
    }
}
