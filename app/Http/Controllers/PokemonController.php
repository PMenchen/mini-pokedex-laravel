<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Controlador para gestionar Pokemon.
 * 
 * Proporciona operaciones CRUD completas para la entidad Pokemon.
 * Incluye metodo adicional para filtrar Pokemon por entrenador.
 */
class PokemonController extends Controller
{
    /**
     * Obtiene todos los Pokemon.
     * 
     * Retorna una lista de todos los Pokemon con su entrenador asociado.
     * 
     * @return JsonResponse Lista de Pokemon con codigo 200
     */
    public function index(): JsonResponse
    {
        // Obtener todos los Pokemon con su entrenador (eager loading)
        $pokemons = Pokemon::with('entrenador')->get();

        return response()->json([
            'success' => true,
            'data' => $pokemons,
            'message' => 'Listado de pokemons obtenido correctamente'
        ]);
    }

    /**
     * Obtiene un Pokemon especifico por su ID.
     * 
     * @param int $id ID del Pokemon a buscar
     * @return JsonResponse Pokemon encontrado o error 404
     */
    public function show(int $id): JsonResponse
    {
        // Buscar Pokemon por ID incluyendo su entrenador
        $pokemon = Pokemon::with('entrenador')->find($id);

        // Verificar si el Pokemon existe
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

    /**
     * Crea un nuevo Pokemon.
     * 
     * Valida los datos de entrada y crea un nuevo registro.
     * El entrenador_id debe existir en la tabla entrenadores.
     * 
     * @param Request $request Datos del nuevo Pokemon
     * @return JsonResponse Pokemon creado con codigo 201
     */
    public function store(Request $request): JsonResponse
    {
        // Validacion de datos de entrada
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',              // Nombre obligatorio
            'tipo' => 'required|string|max:100',                // Tipo obligatorio
            'nivel' => 'required|integer|min:1|max:100',        // Nivel entre 1 y 100
            'entrenador_id' => 'required|exists:entrenadores,id', // Debe existir el entrenador
        ]);

        // Crear el Pokemon con los datos validados
        $pokemon = Pokemon::create($validated);
        
        // Cargar la relacion con el entrenador para la respuesta
        $pokemon->load('entrenador');

        return response()->json([
            'success' => true,
            'data' => $pokemon,
            'message' => 'Pokemon creado correctamente'
        ], 201);
    }

    /**
     * Actualiza un Pokemon existente.
     * 
     * Permite actualizar uno o varios campos del Pokemon.
     * Usa 'sometimes' para permitir actualizaciones parciales.
     * 
     * @param Request $request Datos a actualizar
     * @param int $id ID del Pokemon a actualizar
     * @return JsonResponse Pokemon actualizado o error 404
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Buscar el Pokemon a actualizar
        $pokemon = Pokemon::find($id);

        // Verificar si el Pokemon existe
        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokemon no encontrado'
            ], 404);
        }

        // Validacion de datos (sometimes permite campos opcionales)
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|string|max:100',
            'nivel' => 'sometimes|required|integer|min:1|max:100',
            'entrenador_id' => 'sometimes|required|exists:entrenadores,id',
        ]);

        // Actualizar el Pokemon con los datos validados
        $pokemon->update($validated);
        
        // Cargar la relacion con el entrenador para la respuesta
        $pokemon->load('entrenador');

        return response()->json([
            'success' => true,
            'data' => $pokemon,
            'message' => 'Pokemon actualizado correctamente'
        ]);
    }

    /**
     * Elimina un Pokemon.
     * 
     * Elimina el Pokemon de la base de datos.
     * Nota: Los combates asociados se eliminaran en cascada segun la migracion.
     * 
     * @param int $id ID del Pokemon a eliminar
     * @return JsonResponse Confirmacion de eliminacion o error 404
     */
    public function destroy(int $id): JsonResponse
    {
        // Buscar el Pokemon a eliminar
        $pokemon = Pokemon::find($id);

        // Verificar si el Pokemon existe
        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokemon no encontrado'
            ], 404);
        }

        // Eliminar el Pokemon
        $pokemon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pokemon eliminado correctamente'
        ]);
    }

    /**
     * Obtiene todos los Pokemon de un entrenador especifico.
     * 
     * Filtra los Pokemon por el ID del entrenador proporcionado.
     * 
     * @param int $entrenadorId ID del entrenador
     * @return JsonResponse Lista de Pokemon del entrenador
     */
    public function porEntrenador(int $entrenadorId): JsonResponse
    {
        // Filtrar Pokemon por entrenador_id e incluir la relacion
        $pokemons = Pokemon::where('entrenador_id', $entrenadorId)
            ->with('entrenador')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pokemons,
            'message' => 'Pokemons del entrenador obtenidos correctamente'
        ]);
    }
}
