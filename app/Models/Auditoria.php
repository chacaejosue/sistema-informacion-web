<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'usuario_id',
        'accion',
        'entidad',
        'entidad_id',
        'descripcion',
        'valores_anteriores',
        'valores_nuevos',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'valores_anteriores' => 'array',
            'valores_nuevos' => 'array',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public static function registrar(
        string $accion,
        Model $entidad,
        ?string $descripcion = null,
        ?array $valoresAnteriores = null,
        ?array $valoresNuevos = null,
    ): void {
        static::create([
            'usuario_id' => Auth::id(),
            'accion' => $accion,
            'entidad' => $entidad::class,
            'entidad_id' => $entidad->getKey(),
            'descripcion' => $descripcion,
            'valores_anteriores' => $valoresAnteriores,
            'valores_nuevos' => $valoresNuevos,
            'ip' => request()->ip(),
        ]);
    }
}
