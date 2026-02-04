<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Combate
 * 
 * Representa un combate entre dos Pokemon.
 * Cada combate tiene un Pokemon local, un Pokemon visitante, fecha y resultado.
 */
class Combate extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'pokemon_local_id',      // ID del Pokemon que combate como local
        'pokemon_visitante_id',  // ID del Pokemon que combate como visitante
        'fecha',                 // Fecha y hora del combate
        'resultado'              // Resultado del combate (formato: "X-Y")
    ];

    /**
     * Conversion de tipos para los atributos.
     * Convierte el campo 'fecha' a objeto datetime.
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * Relacion muchos a uno con Pokemon (local).
     * Obtiene el Pokemon que participa como local en el combate.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pokemonLocal()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_local_id');
    }

    /**
     * Relacion muchos a uno con Pokemon (visitante).
     * Obtiene el Pokemon que participa como visitante en el combate.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pokemonVisitante()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_visitante_id');
    }
}
