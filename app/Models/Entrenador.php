<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Entrenador
 * 
 * Representa un entrenador Pokemon con sus datos personales.
 * Un entrenador puede tener varios Pokemon bajo su tutela.
 */
class Entrenador extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'nombre',   // Nombre del entrenador
        'ciudad',   // Ciudad de origen del entrenador
        'edad'      // Edad del entrenador (entre 10 y 100)
    ];

    /**
     * Nombre de la tabla en la base de datos.
     * 
     * @var string
     */
    protected $table = 'entrenadores';

    /**
     * Relacion uno a muchos con Pokemon.
     * Un entrenador puede tener muchos Pokemon.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pokemons()
    {
        return $this->hasMany(Pokemon::class);
    }
}
