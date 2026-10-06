<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoPublicoRequest;
use App\Models\Cliente;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Persona;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PedidoPublicoController extends Controller
{
    public function create(): View
    {
        $productos = Producto::with(['categoria', 'proveedor'])
            ->where('activo', true)
            ->where('publicado', true)
            ->whereHas('categoria', fn ($query) => $query->where('activo', true))
            ->orderBy('nombre')
            ->get();

        return view('pedidos.publico.create', compact('productos'));
    }

    public function store(PedidoPublicoRequest $request): View|RedirectResponse
    {
        $validated = $request->validated();
        $items = collect($validated['carrito'])->keyBy('producto_id');
        $productos = Producto::with('categoria')
            ->whereIn('id', $items->keys())
            ->where('activo', true)
            ->where('publicado', true)
            ->whereHas('categoria', fn ($query) => $query->where('activo', true))
            ->get()
            ->keyBy('id');

        if ($productos->count() !== $items->count()) {
            return back()->withInput()->withErrors([
                'carrito' => 'Uno o más productos ya no están disponibles en el catálogo.',
            ]);
        }

        $pedido = DB::transaction(function () use ($validated, $productos, $items, $request): Pedido {
            $cliente = $this->resolverCliente($validated, $request);

            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'registrado_por_usuario_id' => null,
                'fecha' => now(),
                'estado' => 'PENDIENTE',
                'observaciones' => trim(sprintf(
                    'Solicitud desde catálogo web. Preferencia de pago: %s.%s',
                    $validated['preferencia_pago'],
                    filled($validated['observaciones'] ?? null) ? ' '.$validated['observaciones'] : '',
                )),
            ]);

            foreach ($items as $productoId => $item) {
                $producto = $productos->get((int) $productoId);

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'cantidad_reservada' => 0,
                    'precio_acordado' => $producto->precio_venta_actual,
                    'estado' => 'PENDIENTE',
                ]);
            }

            return $pedido;
        });

        $pedido->load(['cliente.persona', 'detalles.producto']);

        return view('pedidos.publico.confirmacion', [
            'pedido' => $pedido,
            'whatsappUrl' => $this->crearEnlaceWhatsApp($pedido, $validated['preferencia_pago']),
        ]);
    }

    private function resolverCliente(array $validated, PedidoPublicoRequest $request): Cliente
    {
        $cliente = $request->user()?->persona?->cliente;

        if ($cliente) {
            return $cliente;
        }

        $persona = null;

        if (filled($validated['email'] ?? null)) {
            $persona = Persona::whereHas('cliente')
                ->where('email', $validated['email'])
                ->first();
        }

        if (! $persona && filled($validated['telefono'] ?? null)) {
            $persona = Persona::whereHas('cliente')
                ->where('telefono', $validated['telefono'])
                ->first();
        }

        if (! $persona) {
            $email = $validated['email'] ?? null;

            if ($email && Persona::where('email', $email)->exists()) {
                $email = null;
            }

            $persona = Persona::create([
                'nombre' => mb_strtoupper(trim($validated['nombre']), 'UTF-8'),
                'apellido' => filled($validated['apellido'] ?? null) ? mb_strtoupper(trim($validated['apellido']), 'UTF-8') : null,
                'telefono' => $validated['telefono'],
                'email' => $email,
                'direccion' => $validated['direccion'] ?? null,
            ]);
        } else {
            $persona->update(array_filter([
                'telefono' => $validated['telefono'],
                'email' => $validated['email'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
            ], static fn ($value): bool => filled($value)));
        }

        return Cliente::firstOrCreate(
            ['persona_id' => $persona->id],
            ['activo' => true, 'observaciones' => 'Registrado desde catálogo web.'],
        );
    }

    private function crearEnlaceWhatsApp(Pedido $pedido, string $preferenciaPago): ?string
    {
        $telefono = config('services.whatsapp.phone');

        if (! filled($telefono)) {
            return null;
        }

        $detalle = $pedido->detalles->map(fn (DetallePedido $detalle): string => sprintf(
            '• %sx %s — Bs %s',
            $detalle->cantidad,
            $detalle->producto->nombre,
            number_format((float) $detalle->precio_acordado * $detalle->cantidad, 2, ',', '.'),
        ))->implode("\n");

        $mensaje = sprintf(
            "Hola, quiero consultar el pedido #%d de Finora.\n\n%s\n\n• Total estimado: Bs %s\n• Preferencia de pago: %s",
            $pedido->id,
            $detalle,
            number_format($pedido->total, 2, ',', '.'),
            $preferenciaPago,
        );

        return 'https://wa.me/'.preg_replace('/\D+/', '', $telefono).'?text='.urlencode($mensaje);
    }
}
