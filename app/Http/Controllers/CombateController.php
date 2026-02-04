<?php

namespace App\Http\Controllers;

use App\Models\Combate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Controlador para gestionar combates Pokemon.
 * 
 * Proporciona operaciones CRUD completas para la entidad Combate.
 * Cada combate enfrenta a dos Pokemon (local vs visitante).
 */
class CombateController extends Controller
{
    /**
     * Obtiene todos los combates.
     * 
     * Retorna una lista de todos los combates con los Pokemon participantes.
     * 
     * @return JsonResponse Lista de combates con codigo 200
     */
    public function index(): JsonResponse
    {
        // Obtener todos los combates con los Pokemon participantes (eager loading)
        $combates = Combate::with(['pokemonLocal', 'pokemonVisitante'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $combates,
            'message' => 'Listado de combates obtenido correctamente'
        ]);
    }

    /**
     * Obtiene un combate especifico por su ID.
     * 
     * @param int $id ID del combate a buscar
     * @return JsonResponse Combate encontrado o error 404
     */
    public function show(int $id): JsonResponse
    {
        // Buscar combate por ID incluyendo los Pokemon participantes
        $combate = Combate::with(['pokemonLocal', 'pokemonVisitante'])->find($id);

        // Verificar si el combate existe
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

    /**
     * Crea un nuevo combate.
     * 
     * Valida los datos de entrada y crea un nuevo registro.
     * Los Pokemon local y visitante deben ser diferentes.
     * 
     * @param Request $request Datos del nuevo combate
     * @return JsonResponse Combate creado con codigo 201
     */
    public function store(Request $request): JsonResponse
    {
        // Validacion de datos de entrada
        $validated = $request->validate([
            'pokemon_local_id' => 'required|exists:pokemons,id',                      // Pokemon local debe existir
            'pokemon_visitante_id' => 'required|exists:pokemons,id|different:pokemon_local_id', // Pokemon visitante diferente al local
            'fecha' => 'required|date',                                               // Fecha obligatoria
            'resultado' => 'nullable|string|regex:/^\d+-\d+$/',                       // Resultado formato "X-Y" (opcional)
        ]);

        // Crear el combate con los datos validados
        $combate = Combate::create($validated);
        
        // Cargar las relaciones con los Pokemon para la respuesta
        $combate->load(['pokemonLocal', 'pokemonVisitante']);

        return response()->json([
            'success' => true,
            'data' => $combate,
            'message' => 'Combate creado correctamente'
        ], 201);
    }

    /**
     * Actualiza un combate existente.
     * 
     * Permite actualizar uno o varios campos del combate.
     * Usa 'sometimes' para permitir actualizaciones parciales.
     * 
     * @param Request $request Datos a actualizar
     * @param int $id ID del combate a actualizar
     * @return JsonResponse Combate actualizado o error 404
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Buscar el combate a actualizar
        $combate = Combate::find($id);

        // Verificar si el combate existe
        if (!$combate) {
            return response()->json([
                'success' => false,
                'message' => 'Combate no encontrado'
            ], 404);
        }

        // Validacion de datos (sometimes permite campos opcionales)
        $validated = $request->validate([
            'pokemon_local_id' => 'sometimes|required|exists:pokemons,id',
            'pokemon_visitante_id' => 'sometimes|required|exists:pokemons,id',
            'fecha' => 'sometimes|required|date',
            'resultado' => 'nullable|string|regex:/^\d+-\d+$/',
        ]);

        // Actualizar el combate con los datos validados
        $combate->update($validated);
        
        // Cargar las relaciones con los Pokemon para la respuesta
        $combate->load(['pokemonLocal', 'pokemonVisitante']);

        return response()->json([
            'success' => true,
            'data' => $combate,
            'message' => 'Combate actualizado correctamente'
        ]);
    }

    /**
     * Elimina un combate.
     * 
     * Elimina el combate de la base de datos.
     * 
     * @param int $id ID del combate a eliminar
     * @return JsonResponse Confirmacion de eliminacion o error 404
     */
    public function destroy(int $id): JsonResponse
    {
        // Buscar el combate a eliminar
        $combate = Combate::find($id);

        // Verificar si el combate existe
        if (!$combate) {
            return response()->json([
                'success' => false,
                'message' => 'Combate no encontrado'
            ], 404);
        }

        // Eliminar el combate
        $combate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Combate eliminado correctamente'
        ]);
    }
}
