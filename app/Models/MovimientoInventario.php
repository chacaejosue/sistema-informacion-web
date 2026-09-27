<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'producto_id',
        'registrado_por_usuario_id',
        'detalle_compra_id',
        'detalle_venta_id',
        'tipo',
        'cantidad',
        'fecha',
        'observacion',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'fecha' => 'datetime',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'registrado_por_usuario_id');
    }

    public function detalleCompra(): BelongsTo
    {
        return $this->belongsTo(DetalleCompra::class, 'detalle_compra_id');
    }

    public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class, 'detalle_venta_id');
    }
}
