<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionAbastecimiento extends Model
{
    protected $table = 'asignaciones_abastecimiento';

    protected $fillable = [
        'detalle_compra_id',
        'detalle_pedido_id',
        'cantidad',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
        ];
    }

    public function detalleCompra(): BelongsTo
    {
        return $this->belongsTo(DetalleCompra::class, 'detalle_compra_id');
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'detalle_pedido_id');
    }
}
