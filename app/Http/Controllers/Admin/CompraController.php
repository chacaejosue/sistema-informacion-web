<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\MovimientoInventario;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::with(['proveedor', 'registradoPor.persona']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->input('proveedor_id'));
        }

        $compras = $query->latest('id')->paginate(15)->withQueryString();
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();

        return view('panel.compras.index', compact('compras', 'proveedores'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();

        return view('panel.compras.create', compact('proveedores', 'productos'));
    }

    public function store(CompraRequest $request)
    {
        $validated = $request->validated();

        $compra = DB::transaction(function () use ($validated, $request) {
            $compra = Compra::create([
                'proveedor_id' => $validated['proveedor_id'],
                'registrado_por_usuario_id' => $request->user()->id,
                'fecha_solicitud' => now(),
                'estado' => 'BORRADOR',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($validated['detalles'] as $item) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'costo_unitario' => $item['costo_unitario'],
                ]);
            }

            return $compra;
        });

        return redirect()->route('panel.compras.show', $compra)
            ->with('exito', 'Compra guardada en borrador correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load(['proveedor', 'registradoPor.persona', 'detalles.producto']);

        return view('panel.compras.show', compact('compra'));
    }

    public function cambiarEstado(Request $request, Compra $compra)
    {
        $nuevoEstado = $request->input('estado');
        $estadosValidos = ['BORRADOR', 'SOLICITADA', 'EN_CAMINO', 'RECIBIDA', 'CANCELADA'];

        if (! in_array($nuevoEstado, $estadosValidos)) {
            return redirect()->back()->withErrors(['error' => 'Estado no válido.']);
        }

        if ($compra->estado === 'RECIBIDA') {
            return redirect()->back()->withErrors(['error' => 'Una compra que ya ha sido recibida no puede modificar su estado.']);
        }

        DB::transaction(function () use ($compra, $nuevoEstado, $request) {
            if ($nuevoEstado === 'RECIBIDA') {
                $compra->update([
                    'estado' => 'RECIBIDA',
                    'fecha_recepcion' => now(),
                ]);

                foreach ($compra->detalles as $detalle) {
                    MovimientoInventario::create([
                        'producto_id' => $detalle->producto_id,
                        'registrado_por_usuario_id' => $request->user()->id,
                        'detalle_compra_id' => $detalle->id,
                        'tipo' => 'ENTRADA_COMPRA',
                        'cantidad' => $detalle->cantidad,
                        'fecha' => now(),
                        'observacion' => "Ingreso por recepción de compra #{$compra->id}",
                    ]);
                }
            } else {
                $compra->update(['estado' => $nuevoEstado]);
            }
        });

        return redirect()->route('panel.compras.show', $compra)
            ->with('exito', "Estado de la compra actualizado a {$nuevoEstado}.");
    }
}
