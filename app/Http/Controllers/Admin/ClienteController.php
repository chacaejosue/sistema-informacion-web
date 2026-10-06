<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\CrearAccesoClienteRequest;
use App\Models\Auditoria;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::with('persona');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('persona', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        if ($request->has('activo') && $request->input('activo') !== '') {
            $query->where('activo', (bool) $request->input('activo'));
        }

        $clientes = $query->latest('id')->paginate(15)->withQueryString();

        return view('panel.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('panel.clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $persona = Persona::create([
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'email' => $validated['email'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
            ]);

            Cliente::create([
                'persona_id' => $persona->id,
                'observaciones' => $validated['observaciones'] ?? null,
                'activo' => $validated['activo'] ?? true,
            ]);

            Auditoria::registrar('CREAR_CLIENTE', $persona, 'Cliente registrado en el sistema.');
        });

        return redirect()->route('panel.clientes.index')
            ->with('exito', 'Cliente registrado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['persona', 'pedidos.detalles.producto', 'ventas.detalles.producto', 'ventas.pagos']);

        $totalDeuda = $cliente->ventas
            ->where('estado', 'CONFIRMADA')
            ->sum(fn ($venta) => $venta->saldo_pendiente);

        return view('panel.clientes.show', compact('cliente', 'totalDeuda'));
    }

    public function edit(Cliente $cliente)
    {
        $cliente->load('persona');

        return view('panel.clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $cliente, $request) {
            $cliente->persona->update([
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'email' => $validated['email'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
            ]);

            $cliente->update([
                'observaciones' => $validated['observaciones'] ?? null,
                'activo' => $request->has('activo') ? (bool) $request->input('activo') : $cliente->activo,
            ]);

            Auditoria::registrar('ACTUALIZAR_CLIENTE', $cliente, 'Datos del cliente actualizados.');
        });

        return redirect()->route('panel.clientes.index')
            ->with('exito', 'Cliente actualizado exitosamente.');
    }

    public function toggleStatus(Cliente $cliente)
    {
        $cliente->update(['activo' => ! $cliente->activo]);

        $estadoText = $cliente->activo ? 'activado' : 'desactivado';

        return redirect()->back()
            ->with('exito', "Cliente {$estadoText} correctamente.");
    }

    public function crearAcceso(CrearAccesoClienteRequest $request, Cliente $cliente)
    {
        if ($cliente->persona->usuario()->exists()) {
            return redirect()->back()->withErrors(['acceso' => 'Este cliente ya tiene una cuenta de acceso.']);
        }

        DB::transaction(function () use ($request, $cliente): void {
            $cliente->persona->update(['email' => $request->validated('email')]);

            Usuario::create([
                'persona_id' => $cliente->persona_id,
                'password' => Hash::make($request->validated('password')),
                'rol' => 'CLIENTE',
                'activo' => true,
            ]);

            Auditoria::registrar('CREAR_ACCESO_CLIENTE', $cliente, 'Se creó el acceso al portal del cliente.');
        });

        return redirect()->back()->with('exito', 'Acceso del cliente creado correctamente.');
    }
}
