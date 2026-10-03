<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'genero',
        'direccion',
    ];

    public function getSaludoAttribute(): string
    {
        $gen = strtoupper(trim((string) $this->genero));
        if ($gen === 'FEMENINO' || $gen === 'F' || $gen === 'MUJER') {
            return 'Bienvenida';
        }

        return 'Bienvenido';
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'persona_id');
    }
}
