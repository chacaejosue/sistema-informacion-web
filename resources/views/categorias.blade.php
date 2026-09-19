<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo por Categorías - Finora</title>

    <!-- Favicon de Finora -->
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}">

    <!-- Tipografías de Google: Outfit & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@500;600;700&amp;display=swap" rel="stylesheet">

    <!-- Iconos Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Carga de estilos y scripts del proyecto mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background font-body-md text-on-surface antialiased selection:bg-secondary selection:text-on-secondary">
    <!-- Encabezado principal del sitio -->
    @include('partials.header')

    @php
        // Datos demostrativos de interfaz (sin MySQL ni inventario real)
        $productos = [
            [
                'nombre' => 'Ilía Clásico Femenino 50ml',
                'categoria' => 'Perfumería',
                'clave' => 'perfumeria',
                'descripcion' => 'Notas florales con jazmín y vainilla.',
                'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAXtGb-yTgj1NScMqY7sR_xLS8jNFHMJVOcvNNPumbDQGc3aT2Stp1l6NRz3vTaSbto60T8Z91LgptMo2i97T7S5Oq7zPtkwzyGJAtWrNBQ20HqFfpNTb3pZ2UaGt5BMLNPDrertfEZI6ohLwN0W-ODrVyLc_FDxDP1h-aZAFrWLbZAr5fyGnqQ2xIbq6YSQy1e8BhlovsC5mxSiG8sW7boqkpsRmr74YMGC3w1htf5qEGMUQzcDDOy',
            ],
            [
                'nombre' => 'Chronos Gel Crema Antiseñales 30+',
                'categoria' => 'Cuidado facial',
                'clave' => 'facial',
                'descripcion' => 'Tratamiento facial de la línea Chronos.',
                'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDWlkYnIHu00cTU7Hr57G-L8Sje7fXhAIj2WBX5HBLAaeXmbdr-U1RUZGfFxiz4hphEaCoO7X2vKULB-g_33VEN5JjhIY33UoDFGyyL0J7gmep6Uh8gc2oUnfkIszmzWYvwOjpYL0H4w9UQQaFSi2s05RuLyrRBCLbCGqV5-zXrlOS90P3sDPeCGiAGDLjFqoQ2n5RGa2uo7WdUb5F6A0ZceHOrGDYrRs2K6yzwYK4vyim4XBpfCapz',
            ],
            [
                'nombre' => 'Set Tododia Nuez Pecán y Cacao',
                'categoria' => 'Cuidado corporal',
                'clave' => 'corporal',
                'descripcion' => 'Conjunto de productos corporales Tododia.',
                'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBM-yHExajLPg6IZwhc4VBHHVp5qJkLsJXhSlIYXOBHfD8ECFixSnkSbEtgASe6gHHOeDFfDuRRhOW-rtcM2EOmgaaIOMopJYPlXstVwIPSemDaq60dCO44qpz0P_Mi53AUSqYF6ddVWXt1cHAISn5KCuFOYQT5h6H4ypLOiwVx6JZvgqkoewR02OBXwNi9W7VwEdBvrVEvVB4gKrGb0ebF7vxFzw4SFn0hKxLOB07PzPJNgpTanFtt',
            ],
            [
                'nombre' => 'Kaiak Aventura Masculino 100ml',
                'categoria' => 'Perfumería',
                'clave' => 'perfumeria',
                'descripcion' => 'Fragancia masculina de la línea Kaiak.',
                'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDIG2wP04rjfdzxvfVsXeXYk0srjLAzYfGG5ME3ozJkSg0bVPgZGB5HMR_I860WwD2gtc552COOZy2E0xcJLHavqzkyBVSjbvg0AwkMatrG6YHrLYeTqKwCIlDlj3G2ZwD8a94kZkab6peoAFnCoPGtinJBt1Li3VStFCdYRiposnF85aD2nTY3EnnFqMBmwdfErQ2rBAOQWWxsNTavv1_CNI5O1KGVLqQRPaUyL8s_9HyfbBPGBPEY',
            ],
        ];

        $categorias = [
            ['clave' => 'perfumeria', 'nombre' => 'Perfumería'],
            ['clave' => 'facial', 'nombre' => 'Cuidado facial'],
            ['clave' => 'corporal', 'nombre' => 'Cuidado corporal'],
        ];
    @endphp

    <!-- Contenido principal del catálogo por categorías -->
    <main id="catalogo" class="max-w-7xl mx-auto px-space-md lg:px-margin pt-28 pb-space-2xl">
        <!-- Encabezado y presentación de la página de categorías -->
        <div class="mb-space-xl">
            <span class="text-secondary font-label-md uppercase tracking-wider">Catálogo demostrativo de Natura</span>
            <h1 class="font-headline-lg text-headline-lg text-primary-container mt-space-xs">Explora por categoría</h1>
            <p class="text-on-surface-variant mt-space-sm">Encuentra productos Natura por nombre o categoría.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
            <!-- Panel lateral: Filtros por categoría de productos -->
            <aside class="lg:col-span-3 rounded-xl bg-surface-container-lowest p-space-lg shadow-sm" aria-label="Filtros del catálogo">
                <h2 class="font-title-lg text-title-lg text-primary-container mb-space-md">Categorías</h2>
                <div class="flex flex-wrap lg:flex-col gap-space-xs" id="categoryFilters">
                    <button type="button" data-category="all" aria-pressed="true"
                        class="category-filter rounded-lg px-space-md py-space-sm text-left bg-secondary text-on-secondary font-title-md transition-colors">Todas</button>
                    @foreach ($categorias as $categoria)
                        <button type="button" data-category="{{ $categoria['clave'] }}" aria-pressed="false"
                            class="category-filter rounded-lg px-space-md py-space-sm text-left bg-surface-container-low text-on-surface font-title-md hover:bg-surface-container-high transition-colors">
                            {{ $categoria['nombre'] }}
                        </button>
                    @endforeach
                </div>
            </aside>

            <!-- Sección principal: Búsqueda y rejilla de productos -->
            <section class="lg:col-span-9 min-w-0" aria-label="Productos del catálogo">
                <!-- Campo de búsqueda reactiva por nombre o categoría -->
                <div class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm mb-space-lg">
                    <label for="catalogSearch" class="block font-title-md text-primary-container mb-space-xs">Buscar productos</label>
                    <input id="catalogSearch" type="search" autocomplete="off"
                        placeholder="Por ejemplo, Ilía o Chronos"
                        class="w-full rounded-lg bg-surface-container-low px-space-md py-space-sm text-on-surface outline-none focus:ring-2 focus:ring-secondary transition-all">
                </div>

                <!-- Contador dinámico de resultados -->
                <p id="resultsCount" class="mb-space-md text-on-surface-variant" role="status" aria-live="polite">
                    {{ count($productos) }} productos demostrativos
                </p>

                <!-- Rejilla con tarjetas de productos del catálogo -->
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-space-lg">
                    @foreach ($productos as $producto)
                        <article data-product-category="{{ $producto['clave'] }}"
                            class="catalog-product flex flex-col overflow-hidden rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
                            <img src="{{ $producto['imagen'] }}" alt="Imagen de referencia: {{ $producto['nombre'] }}"
                                loading="lazy" class="aspect-square w-full object-cover bg-surface-container-low">
                            <div class="p-space-md flex flex-col gap-space-xs flex-1">
                                <span class="text-secondary font-label-sm uppercase tracking-wider">Natura · {{ $producto['categoria'] }}</span>
                                <h2 class="font-title-lg text-title-lg text-primary-container">{{ $producto['nombre'] }}</h2>
                                <p class="text-on-surface-variant font-body-md">{{ $producto['descripcion'] }}</p>
                                <span class="mt-auto pt-space-md text-on-surface-variant font-label-sm">Información y precio por confirmar</span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Mensaje de estado cuando no hay resultados de búsqueda -->
                <div id="emptyCatalog" class="rounded-xl bg-surface-container-lowest p-space-2xl text-center shadow-sm" style="display: none" role="status">
                    <span class="material-symbols-outlined text-secondary text-[32px]" aria-hidden="true">search_off</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary-container mt-2">No hay resultados</h2>
                    <p class="text-on-surface-variant mt-1">Prueba otra palabra o selecciona «Todas».</p>
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de página reutilizable -->
    @include('partials.footer')

    {{-- La interacción del buscador y los filtros de categoría se maneja en resources/js/app.js --}}
</body>
</html>
