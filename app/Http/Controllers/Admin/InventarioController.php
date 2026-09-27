<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovimientoInventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'linea', 'proveedor'])
            ->where('activo', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        $productos = $query->orderBy('nombre')->paginate(15)->withQueryString();

        return view('panel.inventario.index', compact('productos'));
    }

    public function movimientos(Request $request)
    {
        $query = MovimientoInventario::with(['producto', 'registradoPor.persona', 'detalleCompra.compra', 'detalleVenta.venta']);

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->input('producto_id'));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        $movimientos = $query->latest('fecha')->paginate(20)->withQueryString();
        $productos = Producto::orderBy('nombre')->get();

        return view('panel.inventario.movimientos', compact('movimientos', 'productos'));
    }

    public function ajuste(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => ['required', 'exists:productos,id'],
            'tipo' => ['required', 'in:AJUSTE_ENTRADA,AJUSTE_SALIDA'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'observacion' => ['required', 'string', 'max:255'],
        ]);

        $cantidadSigned = $validated['tipo'] === 'AJUSTE_ENTRADA' ? $validated['cantidad'] : -$validated['cantidad'];

        MovimientoInventario::create([
            'producto_id' => $validated['producto_id'],
            'registrado_por_usuario_id' => $request->user()->id,
            'tipo' => $validated['tipo'],
            'cantidad' => $cantidadSigned,
            'fecha' => now(),
            'observacion' => $validated['observacion'],
        ]);

        return redirect()->back()->with('exito', 'Ajuste de inventario registrado correctamente.');
    }
}
