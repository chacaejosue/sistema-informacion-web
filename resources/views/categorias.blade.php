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

    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="min-h-screen bg-background font-body-md text-on-surface antialiased selection:bg-secondary selection:text-on-secondary">
    <!-- Encabezado principal del sitio -->
    @include('partials.header')

    <!-- Contenido principal del catálogo por categorías -->
    <main id="catalogo" class="max-w-7xl mx-auto px-space-md lg:px-margin pt-28 pb-space-2xl">
        <!-- Encabezado y presentación de la página de categorías -->
        <div class="mb-space-xl">
            <span class="text-secondary font-label-md uppercase tracking-wider">Catálogo Comercial de Natura</span>
            <h1 class="font-headline-lg text-headline-lg text-primary-container mt-space-xs">Explora por categoría</h1>
            <p class="text-on-surface-variant mt-space-sm">Encuentra productos Natura por nombre o categoría.</p>
        </div>

        {{-- 2.1: Grid donde el sidebar y el buscador son sticky --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
            <!-- Panel lateral sticky: Filtros por categoría (2.1) -->
            <aside class="lg:col-span-3 lg:sticky lg:top-24 self-start rounded-xl bg-surface-container-lowest p-space-lg shadow-sm border border-surface-container-high/40" aria-label="Filtros del catálogo">
                <h2 class="font-title-lg text-title-lg text-primary-container mb-space-md">Categorías</h2>
                <div class="flex flex-wrap lg:flex-col gap-space-xs" id="categoryFilters">
                    <button type="button" data-category="all" aria-pressed="true"
                        class="category-filter rounded-lg px-space-md py-space-sm text-left bg-secondary text-on-secondary font-title-md transition-colors">Todas</button>
                    @foreach ($categorias as $categoria)
                        <button type="button" data-category="{{ \Illuminate\Support\Str::slug($categoria->nombre) }}" aria-pressed="false"
                            class="category-filter rounded-lg px-space-md py-space-sm text-left bg-surface-container-low text-on-surface font-title-md hover:bg-surface-container-high transition-colors">
                            {{ $categoria->nombre }}
                        </button>
                    @endforeach
                </div>
            </aside>

            <!-- Sección principal: Búsqueda y rejilla de productos -->
            <section class="lg:col-span-9 min-w-0" aria-label="Productos del catálogo">
                {{-- 2.1: Buscador sticky dentro de la columna principal --}}
                <div class="sticky top-24 z-20 bg-background/95 backdrop-blur-sm pb-space-md pt-1">
                    <div class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container-high/40">
                        <label for="catalogSearch" class="block font-title-md text-primary-container mb-space-xs">Buscar productos</label>
                        <input id="catalogSearch" type="search" autocomplete="off"
                            placeholder="Por ejemplo, Ilía o Chronos"
                            class="w-full rounded-lg bg-surface-container-low px-space-md py-space-sm text-on-surface outline-none focus:ring-2 focus:ring-secondary transition-all">
                    </div>
                </div>

                <!-- Contador dinámico de resultados -->
                <p id="resultsCount" class="mb-space-md text-on-surface-variant" role="status" aria-live="polite">
                    {{ count($productos) }} {{ count($productos) === 1 ? 'producto disponible' : 'productos disponibles' }}
                </p>

                <!-- Rejilla con tarjetas de productos del catálogo -->
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-space-lg">
                    @foreach ($productos as $producto)
                        <article data-product-category="{{ \Illuminate\Support\Str::slug($producto->categoria->nombre) }}"
                            class="catalog-product flex flex-col overflow-hidden rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow border border-surface-container-high/30">
                            {{-- 1.14: No arrastrable --}}
                            <img src="{{ $producto->imagen_url ?: asset('images/branding/finora-icono.png') }}" alt="Imagen de referencia: {{ $producto->nombre }}"
                                loading="lazy" class="aspect-square w-full object-cover bg-surface-container-low select-none" draggable="false">
                            <div class="p-space-md flex flex-col gap-space-xs flex-1">
                                <span class="text-secondary font-label-sm uppercase tracking-wider">Natura · {{ $producto->categoria->nombre }}</span>
                                <h2 class="font-title-lg text-title-lg text-primary-container">{{ $producto->nombre }}</h2>
                                <p class="text-on-surface-variant font-body-md">{{ $producto->descripcion ?: 'Producto del catálogo comercial.' }}</p>
                                <div class="mt-auto pt-space-md flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-secondary font-bold font-title-md">${{ number_format($producto->precio_venta_actual, 2) }} USD</span>
                                    </div>
                                    {{-- 1.15: Botón WhatsApp en cada tarjeta del catálogo --}}
                                    <a href="https://wa.me/59167673537?text=Hola%20deseo%20consultar%20por%20{{ urlencode($producto->nombre) }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="w-full py-2 rounded-lg bg-surface-container text-primary-container hover:bg-secondary hover:text-on-secondary font-title-md text-sm flex items-center justify-center gap-1.5 transition-all">
                                        <span class="material-symbols-outlined text-[16px]">chat</span>
                                        <span>Consultar por WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Mensaje de estado cuando no hay resultados de búsqueda -->
                <div id="emptyCatalog" class="rounded-xl bg-surface-container-lowest p-space-2xl text-center shadow-sm" style="display: {{ count($productos) === 0 ? 'block' : 'none' }}" role="status">
                    <span class="material-symbols-outlined text-secondary text-[32px]" aria-hidden="true">search_off</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary-container mt-2">No hay resultados</h2>
                    <p class="text-on-surface-variant mt-1">No se encontraron productos disponibles en esta categoría.</p>
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de página reutilizable -->
    @include('partials.footer')

    {{-- 1.18: Botón flotante para volver arriba en /categorias --}}
    <button id="backToTopCatalog"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 flex items-center justify-center rounded-full bg-surface-container-lowest shadow-lg border border-surface-container-high/40 text-secondary hover:bg-secondary hover:text-on-secondary transition-all hover:shadow-xl"
        aria-label="Volver arriba" title="Volver arriba" style="display:none"
        onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1.18: Mostrar/ocultar botón volver arriba
            const backToTopBtn = document.getElementById('backToTopCatalog');
            if (backToTopBtn) {
                window.addEventListener('scroll', () => {
                    backToTopBtn.style.display = window.scrollY > 200 ? 'flex' : 'none';
                }, { passive: true });
            }

            // Leer ?categoria=slug de la URL para preseleccionar la categoría activa (1.11 / 2.1)
            const params = new URLSearchParams(window.location.search);
            const categoriaParam = params.get('categoria');
            if (categoriaParam) {
                // Intentar activar el botón de filtro que coincida
                const filters = document.querySelectorAll('#categoryFilters .category-filter');
                filters.forEach(btn => {
                    if (btn.dataset.category === categoriaParam) {
                        // Simular click para activar el filtro
                        btn.click();
                        // Scroll suave al inicio del catálogo
                        setTimeout(() => {
                            document.getElementById('catalogo')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                });
            }
        });
    </script>

    {{-- La interacción del buscador y los filtros de categoría se maneja en resources/js/app.js --}}
</body>
</html>
