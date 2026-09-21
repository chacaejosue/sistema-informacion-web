<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Categoria;
use App\Models\Linea;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Muestra el listado de productos con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Producto::with(['proveedor', 'categoria', 'linea']);

        // Filtro por término de búsqueda (código o nombre)
        if ($search = trim((string) $request->input('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($categoriaId = $request->input('categoria_id')) {
            $query->where('categoria_id', $categoriaId);
        }

        // Filtro por línea
        if ($lineaId = $request->input('linea_id')) {
            $query->where('linea_id', $lineaId);
        }

        // Filtro por estado activo
        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        // Filtro por estado publicado
        if ($request->filled('publicado')) {
            $query->where('publicado', $request->boolean('publicado'));
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();


        $categorias = Categoria::orderBy('nombre')->get();
        $lineas = Linea::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('panel.productos.index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'lineas' => $lineas,
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $lineas = Linea::where('activo', true)->orderBy('nombre')->get();

        return view('panel.productos.create', [
            'proveedores' => $proveedores,
            'categorias' => $categorias,
            'lineas' => $lineas,
        ]);
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(ProductoRequest $request)
    {
        $datos = $request->validated();

        // Manejo de la carga de imagen en almacenamiento público local (guardando ruta relativa)
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $datos['imagen_principal'] = $path;
        } elseif ($request->filled('imagen_url')) {
            $datos['imagen_principal'] = $request->input('imagen_url');
        }

        $datos['publicado'] = $request->boolean('publicado');
        $datos['activo'] = $request->boolean('activo', true);

        Producto::create($datos);

        return redirect()->route('panel.productos.index')
            ->with('exito', 'Producto registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $lineas = Linea::where('activo', true)->orderBy('nombre')->get();

        return view('panel.productos.edit', [
            'producto' => $producto,
            'proveedores' => $proveedores,
            'categorias' => $categorias,
            'lineas' => $lineas,
        ]);
    }

    /**
     * Actualiza la información del producto en la base de datos.
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $datos = $request->validated();

        // Eliminar campos que no son columnas de la tabla
        unset($datos['imagen'], $datos['imagen_url']);

        if ($request->hasFile('imagen')) {
            // Nuevo archivo subido: reemplazar imagen
            $datos['imagen_principal'] = $request->file('imagen')->store('productos', 'public');
        } elseif ($request->filled('imagen_url')) {
            // URL externa provista: usar como imagen
            $datos['imagen_principal'] = $request->input('imagen_url');
        }
        // Si ninguno se envía: conservar imagen_principal existente (no se toca)

        $datos['publicado'] = $request->boolean('publicado');
        $datos['activo'] = $request->boolean('activo');

        $producto->update($datos);

        return redirect()->route('panel.productos.index')
            ->with('exito', 'Producto actualizado correctamente.');
    }

    /**
     * Alterna la visibilidad pública o el estado activo de un producto.
     */
    public function toggleStatus(Request $request, Producto $producto)
    {
        if ($request->has('campo') && in_array($request->input('campo'), ['activo', 'publicado'])) {
            $campo = $request->input('campo');
            $producto->update([
                $campo => ! $producto->{$campo},
            ]);

            return redirect()->back()->with('exito', 'Estado actualizado correctamente.');
        }

        return redirect()->back();
    }

    /**
     * Desactiva el producto (desactivación lógica para preservar historial comercial).
     */
    public function destroy(Producto $producto)
    {
        $producto->update(['activo' => false]);

        return redirect()->route('panel.productos.index')
            ->with('exito', 'Producto desactivado correctamente.');
    }
}
