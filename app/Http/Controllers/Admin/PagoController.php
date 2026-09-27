<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagoRequest;
use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with(['venta.cliente.persona', 'registradoPor.persona']);

        if ($request->filled('venta_id')) {
            $query->where('venta_id', $request->input('venta_id'));
        }

        $pagos = $query->latest('fecha')->paginate(15)->withQueryString();

        // Resumen de cuentas por cobrar por cliente
        $clientesDeudores = Cliente::with(['persona', 'ventas' => function ($q) {
            $q->where('estado', 'CONFIRMADA');
        }])->get()->map(function ($cli) {
            $deuda = $cli->ventas->sum(fn ($v) => $v->saldo_pendiente);
            $cli->total_deuda = $deuda;
            return $cli;
        })->filter(fn ($cli) => $cli->total_deuda > 0);

        return view('panel.pagos.index', compact('pagos', 'clientesDeudores'));
    }

    public function create(Request $request)
    {
        $ventaSeleccionada = null;
        if ($request->filled('venta_id')) {
            $ventaSeleccionada = Venta::with(['cliente.persona', 'detalles.producto', 'pagos'])->find($request->input('venta_id'));
        }

        $ventasConSaldo = Venta::with('cliente.persona')
            ->where('estado', 'CONFIRMADA')
            ->get()
            ->filter(fn ($v) => $v->saldo_pendiente > 0);

        return view('panel.pagos.create', compact('ventasConSaldo', 'ventaSeleccionada'));
    }

    public function store(PagoRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            $pago = Pago::create([
                'venta_id' => $validated['venta_id'],
                'registrado_por_usuario_id' => $request->user()->id,
                'monto' => $validated['monto'],
                'fecha' => now(),
                'metodo' => $validated['metodo'],
                'estado' => 'REGISTRADO',
                'observacion' => $validated['observacion'] ?? null,
            ]);

            $venta = Venta::with('credito')->find($validated['venta_id']);
            if ($venta && $venta->credito && $venta->saldo_pendiente <= 0.01) {
                $venta->credito->update(['estado' => 'PAGADO']);
            }
        });

        return redirect()->route('panel.ventas.show', $validated['venta_id'])
            ->with('exito', 'Pago registrado exitosamente.');
    }
}
