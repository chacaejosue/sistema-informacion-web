<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Listado de proveedores en el panel.
     */
    public function index()
    {
        $proveedores = Proveedor::withCount('productos')->orderBy('nombre')->paginate(10);

        return view('panel.proveedores.index', [
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Almacena un nuevo proveedor.
     */
    public function store(ProveedorRequest $request)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo', true);

        Proveedor::create($datos);

        return redirect()->route('panel.proveedores.index')
            ->with('exito', 'Proveedor registrado correctamente.');
    }

    /**
     * Actualiza la información del proveedor.
     */
    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo');

        $proveedor->update($datos);

        return redirect()->route('panel.proveedores.index')
            ->with('exito', 'Proveedor actualizado correctamente.');
    }

    /**
     * Desactiva lógicamente el proveedor.
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->update(['activo' => false]);

        return redirect()->route('panel.proveedores.index')
            ->with('exito', 'Proveedor desactivado correctamente.');
    }
}
