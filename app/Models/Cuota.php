<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    protected $table = 'cuotas';

    protected $fillable = [
        'credito_id',
        'numero',
        'monto',
        'fecha_vencimiento',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'numero' => 'integer',
            'monto' => 'decimal:2',
            'fecha_vencimiento' => 'date',
        ];
    }

    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(AplicacionPago::class, 'cuota_id');
    }

    public function getMontoAplicadoAttribute(): float
    {
        return (float) $this->aplicaciones()
            ->whereHas('pago', fn ($query) => $query->where('estado', 'REGISTRADO'))
            ->sum('monto_aplicado');
    }

    public function getSaldoPendienteAttribute(): float
    {
        return max(0, (float) $this->monto - $this->monto_aplicado);
    }
}
