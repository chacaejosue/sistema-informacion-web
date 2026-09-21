<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * Muestra el catálogo público de productos clasificados por categoría.
     */
    public function index(Request $request)
    {
        $categorias = Categoria::where('activo', true)
            ->orderBy('nombre', 'asc')
            ->get();

        $productos = Producto::with(['categoria', 'linea'])
            ->where('activo', true)
            ->where('publicado', true)
            ->whereHas('categoria', function ($query) {
                $query->where('activo', true);
            })
            ->orderBy('nombre', 'asc')
            ->get();

        return view('categorias', [
            'categorias' => $categorias,
            'productos' => $productos,
        ]);
    }
}
