<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pokemon
 * 
 * Representa un Pokemon con sus caracteristicas.
 * Cada Pokemon pertenece a un entrenador y puede participar en combates.
 */
class Pokemon extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'entrenador_id',    // ID del entrenador al que pertenece
        'nombre',           // Nombre del Pokemon
        'tipo',             // Tipo de Pokemon (fuego, agua, planta, etc.)
        'nivel'             // Nivel del Pokemon (entre 1 y 100)
    ];

    /**
     * Nombre de la tabla en la base de datos.
     * 
     * @var string
     */
    protected $table = 'pokemons';

    /**
     * Relacion muchos a uno con Entrenador.
     * Un Pokemon pertenece a un unico entrenador.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class);
    }

    /**
     * Relacion uno a muchos con Combate (como Pokemon local).
     * Obtiene todos los combates donde este Pokemon participa como local.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function combatesLocal()
    {
        return $this->hasMany(Combate::class, 'pokemon_local_id');
    }

    /**
     * Relacion uno a muchos con Combate (como Pokemon visitante).
     * Obtiene todos los combates donde este Pokemon participa como visitante.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function combatesVisitante()
    {
        return $this->hasMany(Combate::class, 'pokemon_visitante_id');
    }
}
