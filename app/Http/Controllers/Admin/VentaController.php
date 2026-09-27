<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VentaRequest;
use App\Models\Cliente;
use App\Models\Credito;
use App\Models\DetalleVenta;
use App\Models\MovimientoInventario;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with(['cliente.persona', 'pedido', 'registradoPor.persona']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('forma_pago')) {
            $query->where('forma_pago', $request->input('forma_pago'));
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->input('cliente_id'));
        }

        $ventas = $query->latest('id')->paginate(15)->withQueryString();
        $clientes = Cliente::with('persona')->where('activo', true)->get();

        return view('panel.ventas.index', compact('ventas', 'clientes'));
    }

    public function create(Request $request)
    {
        $pedido = null;
        if ($request->filled('pedido_id')) {
            $pedido = Pedido::with(['cliente.persona', 'detalles.producto'])->find($request->input('pedido_id'));
        }

        $clientes = Cliente::with('persona')->where('activo', true)->get();
        $productos = Producto::where('activo', true)->get();

        return view('panel.ventas.create', compact('clientes', 'productos', 'pedido'));
    }

    public function store(VentaRequest $request)
    {
        $validated = $request->validated();

        $venta = DB::transaction(function () use ($validated, $request) {
            $venta = Venta::create([
                'cliente_id' => $validated['cliente_id'],
                'pedido_id' => $validated['pedido_id'] ?? null,
                'registrado_por_usuario_id' => $request->user()->id,
                'fecha' => now(),
                'forma_pago' => $validated['forma_pago'],
                'estado' => 'BORRADOR',
                'descuento' => $validated['descuento'] ?? 0,
            ]);

            foreach ($validated['detalles'] as $item) {
                $prod = Producto::find($item['producto_id']);
                // Se registra el precio de venta y costo de compra más reciente si existe
                $ultimoCosto = DB::table('detalle_compras')
                    ->where('producto_id', $item['producto_id'])
                    ->latest('id')
                    ->value('costo_unitario') ?? 0;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'costo_unitario' => $ultimoCosto,
                ]);
            }

            return $venta;
        });

        return redirect()->route('panel.ventas.show', $venta)
            ->with('exito', 'Venta registrada en borrador correctamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente.persona', 'registradoPor.persona', 'detalles.producto', 'pagos', 'credito']);

        return view('panel.ventas.show', compact('venta'));
    }

    public function confirmar(Request $request, Venta $venta)
    {
        if ($venta->estado === 'CONFIRMADA') {
            return redirect()->back()->withErrors(['error' => 'Esta venta ya fue confirmada anteriormente.']);
        }

        if (in_array($venta->estado, ['CANCELADA', 'ANULADA'])) {
            return redirect()->back()->withErrors(['error' => 'Una venta cancelada o anulada no puede ser confirmada.']);
        }

        DB::transaction(function () use ($venta, $request) {
            $venta->update(['estado' => 'CONFIRMADA']);

            // Generar salidas de inventario evitando duplicados
            foreach ($venta->detalles as $det) {
                $yaExisteMovimiento = MovimientoInventario::where('detalle_venta_id', $det->id)->exists();
                if (! $yaExisteMovimiento) {
                    MovimientoInventario::create([
                        'producto_id' => $det->producto_id,
                        'registrado_por_usuario_id' => $request->user()->id,
                        'detalle_venta_id' => $det->id,
                        'tipo' => 'SALIDA_VENTA',
                        'cantidad' => -1 * abs($det->cantidad),
                        'fecha' => now(),
                        'observacion' => "Salida por confirmación de venta #{$venta->id}",
                    ]);
                }
            }

            // Si proviene de un pedido, liberar las reservas y marcar pedido como COMPLETADO
            if ($venta->pedido) {
                foreach ($venta->pedido->detalles as $detPed) {
                    $detPed->update(['cantidad_reservada' => 0, 'estado' => 'ENTREGADO']);
                }
                $venta->pedido->update(['estado' => 'COMPLETADO']);
            }

            // Si es a crédito, registrar entrada en la tabla creditos
            if ($venta->forma_pago === 'CREDITO') {
                Credito::firstOrCreate(
                    ['venta_id' => $venta->id],
                    [
                        'monto_financiado' => $venta->total,
                        'interes_porcentaje' => 0,
                        'fecha_inicio' => now(),
                        'fecha_fin' => now()->addDays(30),
                        'estado' => 'ACTIVO',
                    ]
                );
            }
        });

        return redirect()->route('panel.ventas.show', $venta)
            ->with('exito', 'Venta confirmada exitosamente. Salidas de inventario registradas.');
    }

    public function anular(Venta $venta)
    {
        if ($venta->estado === 'ANULADA') {
            return redirect()->back()->withErrors(['error' => 'La venta ya se encuentra anulada.']);
        }

        DB::transaction(function () use ($venta) {
            $eraConfirmada = ($venta->estado === 'CONFIRMADA');
            $venta->update(['estado' => 'ANULADA']);

            if ($eraConfirmada) {
                // Registrar reverso en movimientos de inventario
                foreach ($venta->detalles as $det) {
                    MovimientoInventario::create([
                        'producto_id' => $det->producto_id,
                        'registrado_por_usuario_id' => auth()->id(),
                        'detalle_venta_id' => $det->id,
                        'tipo' => 'REVERSO',
                        'cantidad' => abs($det->cantidad),
                        'fecha' => now(),
                        'observacion' => "Reverso por anulación de venta #{$venta->id}",
                    ]);
                }

                // Anular crédito si existe
                if ($venta->credito) {
                    $venta->credito->update(['estado' => 'ANULADO']);
                }
            }
        });

        return redirect()->route('panel.ventas.show', $venta)
            ->with('exito', 'Venta anulada correctamente.');
    }
}
