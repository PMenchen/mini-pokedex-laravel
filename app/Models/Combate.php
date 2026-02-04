<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Partido
 * 
 * Representa un partido entre dos clubes dentro de una liga.
 */
class Combate extends Model
{
    use HasFactory;

    protected $fillable = [
        'pokemon_local_id',
        'pokemon_visitante_id',
        'fecha',
        'resultado'
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function pokemonLocal()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_local_id');
    }

    public function pokemonVisitante()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_visitante_id');
    }

}