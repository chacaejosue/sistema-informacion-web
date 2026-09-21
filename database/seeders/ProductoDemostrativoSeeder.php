<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Linea;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProductoDemostrativoSeeder extends Seeder
{
    /**
     * Migra los datos demostrativos del catálogo hacia MySQL.
     * Este seeder es idempotente y utiliza firstOrCreate para no sobrescribir ediciones posteriores.
     */
    public function run(): void
    {
        // 1. Proveedor con datos explícitamente ficticios
        $proveedor = Proveedor::firstOrCreate(
            ['nombre' => 'Natura (Proveedor Ficticio)'],
            [
                'telefono' => null,
                'email' => 'ejemplo@example.com',
                'sitio_web' => null,
                'activo' => true,
            ]
        );

        // 2. Categorías demostrativas
        $perfumeria = Categoria::firstOrCreate(
            ['nombre' => 'Perfumería'],
            ['descripcion' => 'Fragancias femeninas y masculinas', 'activo' => true]
        );

        $facial = Categoria::firstOrCreate(
            ['nombre' => 'Cuidado facial'],
            ['descripcion' => 'Tratamientos antiseñales e hidratantes faciales', 'activo' => true]
        );

        $corporal = Categoria::firstOrCreate(
            ['nombre' => 'Cuidado corporal'],
            ['descripcion' => 'Kits de cuidado corporal y lociones', 'activo' => true]
        );

        // 3. Líneas comerciales demostrativas
        $lineaIlia = Linea::firstOrCreate(
            ['nombre' => 'Ilía'],
            ['descripcion' => 'Línea de perfumería femenina', 'activo' => true]
        );

        $lineaChronos = Linea::firstOrCreate(
            ['nombre' => 'Chronos'],
            ['descripcion' => 'Línea de tratamiento antiseñales', 'activo' => true]
        );

        $lineaTododia = Linea::firstOrCreate(
            ['nombre' => 'Tododia'],
            ['descripcion' => 'Línea de cuidado diario e hidratación', 'activo' => true]
        );

        $lineaKaiak = Linea::firstOrCreate(
            ['nombre' => 'Kaiak'],
            ['descripcion' => 'Línea de perfumería fresca', 'activo' => true]
        );

        // 4. Productos demostrativos con precios de referencia ficticios en USD
        //    Las imágenes están versionadas en public/images/demo/productos/ (rastreadas por Git).
        $productos = [
            [
                'codigo' => 'NAT-ILIA-001',
                'nombre' => 'Ilía Clásico Femenino 50ml',
                'descripcion' => 'Notas florales con jazmín y vainilla. Precio de referencia de ejemplo.',
                'categoria_id' => $perfumeria->id,
                'linea_id' => $lineaIlia->id,
                'precio_venta_actual' => 35.00,
                'imagen_principal' => 'demo/productos/ilia.jpg',
            ],
            [
                'codigo' => 'NAT-CHRO-001',
                'nombre' => 'Chronos Gel Crema Antiseñales 30+',
                'descripcion' => 'Tratamiento facial de la línea Chronos. Precio de referencia de ejemplo.',
                'categoria_id' => $facial->id,
                'linea_id' => $lineaChronos->id,
                'precio_venta_actual' => 42.00,
                'imagen_principal' => 'demo/productos/chronos.jpg',
            ],
            [
                'codigo' => 'NAT-TODO-001',
                'nombre' => 'Set Tododia Nuez Pecán y Cacao',
                'descripcion' => 'Conjunto de productos corporales Tododia. Precio de referencia de ejemplo.',
                'categoria_id' => $corporal->id,
                'linea_id' => $lineaTododia->id,
                'precio_venta_actual' => 28.00,
                'imagen_principal' => 'demo/productos/tododia.jpg',
            ],
            [
                'codigo' => 'NAT-KAIA-001',
                'nombre' => 'Kaiak Aventura Masculino 100ml',
                'descripcion' => 'Fragancia masculina de la línea Kaiak. Precio de referencia de ejemplo.',
                'categoria_id' => $perfumeria->id,
                'linea_id' => $lineaKaiak->id,
                'precio_venta_actual' => 38.00,
                'imagen_principal' => 'demo/productos/kaiak.jpg',
            ],
        ];

        foreach ($productos as $datos) {
            // firstOrCreate para no sobrescribir cambios realizados por el consultor desde el panel
            Producto::firstOrCreate(
                ['codigo' => $datos['codigo']],
                [
                    'proveedor_id' => $proveedor->id,
                    'linea_id' => $datos['linea_id'],
                    'categoria_id' => $datos['categoria_id'],
                    'nombre' => $datos['nombre'],
                    'descripcion' => $datos['descripcion'],
                    'precio_venta_actual' => $datos['precio_venta_actual'],
                    'imagen_principal' => $datos['imagen_principal'],
                    'publicado' => true,
                    'activo' => true,
                ]
            );
        }
    }
}
