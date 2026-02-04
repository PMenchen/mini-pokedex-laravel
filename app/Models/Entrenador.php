<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'ciudad',
        'edad'
    ];

    protected $table = 'entrenadores';

    public function pokemon(){
        return $this->hasMany(Pokemon::class);
    }
}