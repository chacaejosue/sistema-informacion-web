<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'cantidad_reservada',
        'precio_acordado',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'cantidad_reservada' => 'integer',
            'precio_acordado' => 'decimal:2',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function asignacionesAbastecimiento(): HasMany
    {
        return $this->hasMany(AsignacionAbastecimiento::class, 'detalle_pedido_id');
    }

    public function getSubtotalAttribute(): float
    {
        return (float) ($this->cantidad * $this->precio_acordado);
    }
}
