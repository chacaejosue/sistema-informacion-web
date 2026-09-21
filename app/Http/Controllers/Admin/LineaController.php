<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineaRequest;
use App\Models\Linea;

class LineaController extends Controller
{
    /**
     * Listado de líneas comerciales en el panel.
     */
    public function index()
    {
        $lineas = Linea::withCount('productos')->orderBy('nombre')->paginate(10);

        return view('panel.lineas.index', [
            'lineas' => $lineas,
        ]);
    }

    /**
     * Almacena una nueva línea comercial.
     */
    public function store(LineaRequest $request)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo', true);

        Linea::create($datos);

        return redirect()->route('panel.lineas.index')
            ->with('exito', 'Línea comercial registrada correctamente.');
    }

    /**
     * Actualiza la información de la línea.
     */
    public function update(LineaRequest $request, Linea $linea)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo');

        $linea->update($datos);

        return redirect()->route('panel.lineas.index')
            ->with('exito', 'Línea comercial actualizada correctamente.');
    }

    /**
     * Desactiva lógicamente la línea.
     */
    public function destroy(Linea $linea)
    {
        $linea->update(['activo' => false]);

        return redirect()->route('panel.lineas.index')
            ->with('exito', 'Línea comercial desactivada correctamente.');
    }
}
