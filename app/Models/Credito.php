<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credito extends Model
{
    protected $table = 'creditos';

    protected $fillable = [
        'venta_id',
        'monto_financiado',
        'numero_cuotas',
        'interes_porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'monto_financiado' => 'decimal:2',
            'numero_cuotas' => 'integer',
            'interes_porcentaje' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class, 'credito_id');
    }
}
