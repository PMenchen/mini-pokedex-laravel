<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Controlador para gestionar entrenadores Pokemon.
 * 
 * Proporciona operaciones CRUD completas para la entidad Entrenador.
 * Todas las respuestas siguen un formato JSON estandarizado.
 */
class EntrenadorController extends Controller
{
    /**
     * Obtiene todos los entrenadores.
     * 
     * Retorna una lista de todos los entrenadores con sus Pokemon asociados.
     * 
     * @return JsonResponse Lista de entrenadores con codigo 200
     */
    public function index(): JsonResponse
    {
        // Obtener todos los entrenadores con sus pokemons (eager loading)
        $entrenadores = Entrenador::with('pokemons')->get();

        return response()->json([
            'success' => true,
            'data' => $entrenadores,
            'message' => 'Listado de entrenadores obtenido correctamente'
        ]);
    }

    /**
     * Obtiene un entrenador especifico por su ID.
     * 
     * @param int $id ID del entrenador a buscar
     * @return JsonResponse Entrenador encontrado o error 404
     */
    public function show(int $id): JsonResponse
    {
        // Buscar entrenador por ID incluyendo sus pokemons
        $entrenador = Entrenador::with('pokemons')->find($id);

        // Verificar si el entrenador existe
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

    /**
     * Crea un nuevo entrenador.
     * 
     * Valida los datos de entrada y crea un nuevo registro en la base de datos.
     * 
     * @param Request $request Datos del nuevo entrenador
     * @return JsonResponse Entrenador creado con codigo 201
     */
    public function store(Request $request): JsonResponse
    {
        // Validacion de datos de entrada
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',      // Nombre obligatorio
            'ciudad' => 'required|string|max:255',      // Ciudad obligatoria
            'edad' => 'required|integer|min:10|max:100', // Edad entre 10 y 100
        ]);

        // Crear el entrenador con los datos validados
        $entrenador = Entrenador::create($validated);

        return response()->json([
            'success' => true,
            'data' => $entrenador,
            'message' => 'Entrenador creado correctamente'
        ], 201);
    }

    /**
     * Actualiza un entrenador existente.
     * 
     * Permite actualizar uno o varios campos del entrenador.
     * Usa 'sometimes' para permitir actualizaciones parciales.
     * 
     * @param Request $request Datos a actualizar
     * @param int $id ID del entrenador a actualizar
     * @return JsonResponse Entrenador actualizado o error 404
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Buscar el entrenador a actualizar
        $entrenador = Entrenador::find($id);

        // Verificar si el entrenador existe
        if (!$entrenador) {
            return response()->json([
                'success' => false,
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        // Validacion de datos (sometimes permite campos opcionales)
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'ciudad' => 'sometimes|required|string|max:255',
            'edad' => 'sometimes|required|integer|min:10|max:100',
        ]);

        // Actualizar el entrenador con los datos validados
        $entrenador->update($validated);

        return response()->json([
            'success' => true,
            'data' => $entrenador,
            'message' => 'Entrenador actualizado correctamente'
        ]);
    }

    /**
     * Elimina un entrenador.
     * 
     * Elimina el entrenador de la base de datos.
     * Nota: Los Pokemon asociados se eliminaran en cascada segun la migracion.
     * 
     * @param int $id ID del entrenador a eliminar
     * @return JsonResponse Confirmacion de eliminacion o error 404
     */
    public function destroy(int $id): JsonResponse
    {
        // Buscar el entrenador a eliminar
        $entrenador = Entrenador::find($id);

        // Verificar si el entrenador existe
        if (!$entrenador) {
            return response()->json([
                'success' => false,
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        // Eliminar el entrenador
        $entrenador->delete();

        return response()->json([
            'success' => true,
            'message' => 'Entrenador eliminado correctamente'
        ]);
    }
}
