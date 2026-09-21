<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Listado de categorías en el panel.
     */
    public function index()
    {
        $categorias = Categoria::withCount('productos')->orderBy('nombre')->paginate(10);

        return view('panel.categorias.index', [
            'categorias' => $categorias,
        ]);
    }

    /**
     * Almacena una nueva categoría.
     */
    public function store(CategoriaRequest $request)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo', true);

        Categoria::create($datos);

        return redirect()->route('panel.categorias.index')
            ->with('exito', 'Categoría registrada correctamente.');
    }

    /**
     * Actualiza la información de la categoría.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $datos = $request->validated();
        $datos['activo'] = $request->boolean('activo');

        $categoria->update($datos);

        return redirect()->route('panel.categorias.index')
            ->with('exito', 'Categoría actualizada correctamente.');
    }

    /**
     * Desactiva lógicamente la categoría.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->update(['activo' => false]);

        return redirect()->route('panel.categorias.index')
            ->with('exito', 'Categoría desactivada correctamente.');
    }
}
