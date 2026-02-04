<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EntrenadorController extends Controller
{
    public function index():JsonResponse
    {
        $entrenadores = Entrenador::with('pokemons')->get();

        return response()->json([
            'success' =>true,
            'data' => $entrenadores,
            'message' => 'Listado de entrenadores obtenido correctamente'
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $entrenador = Entrenador::with('pokemons')->find($id);

        if (!$entrenador) {
            return response()->json([
                'success' => false,
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $entrenador,
            'message' => 'Entrenador obtenido correctamente'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'edad' => 'required|integer|min:10|max:100',
        ]);

        $entrenador = Entrenador::create($validated);

        return response()->json([
            'success' => true,
            'data' => $entrenador,
            'message' => 'Entrenador creado correctamente'
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $entrenador = Entrenador::find($id);

        if (!$entrenador) {
            return response()->json([
                'success' => false,
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'ciudad' => 'sometimes|required|string|max:255',
            'edad' => 'sometimes|required|integer|min:10|max:100',
        ]);

        $entrenador->update($validated);

        return response()->json([
            'success' => true,
            'data' => $entrenador,
            'message' => 'Entrenador actualizado correctamente'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $entrenador = Entrenador::find($id);

        if (!$entrenador) {
            return response()->json([
                'success' => false,
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        $entrenador->delete();

        return response()->json([
            'success' => true,
            'message' => 'Entrenador eliminado correctamente'
        ]);
    }
}
