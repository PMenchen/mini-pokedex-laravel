<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrenador_id',
        'nombre',
        'tipo',
        'nivel'
    ];

    protected $table = 'pokemons';

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class);
    }

    public function combatesLocal()
    {
        return $this->hasMany(Combate::class, 'pokemon_local_id');
    }

    public function combatesVisitante()
    {
        return $this->hasMany(Combate::class, 'pokemon_visitante_id');
    }
}