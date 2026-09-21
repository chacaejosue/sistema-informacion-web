<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Linea extends Model
{
    protected $table = 'lineas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    /**
     * Productos asociados a la línea.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'linea_id');
    }
}
