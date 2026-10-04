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
                            class="catalog-product finora-card-interactive flex flex-col overflow-hidden rounded-2xl bg-surface-container-lowest shadow-sm hover:shadow-xl transition-all border border-surface-container-high/40 hover:border-secondary/30 group">
                            <div class="relative aspect-square w-full overflow-hidden bg-surface-container-low">
                                <img src="{{ $producto->imagen_url ?: asset('images/branding/finora-icono.png') }}" alt="{{ $producto->nombre }}"
                                    onerror="this.onerror=null; this.src='{{ asset('images/branding/finora-icono.png') }}';"
                                    loading="lazy" class="w-full h-full object-cover select-none group-hover:scale-108 transition-transform duration-500" draggable="false">
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md bg-surface-container-lowest/90 backdrop-blur-sm text-secondary font-label-sm text-[11px] font-semibold uppercase tracking-wider shadow-xs">
                                    {{ $producto->categoria->nombre }}
                                </span>
                            </div>
                            <div class="p-space-md flex flex-col gap-space-xs flex-1">
                                <span class="text-secondary font-label-sm text-[11px] uppercase tracking-wider font-semibold">Natura</span>
                                <h2 class="font-title-lg text-title-lg text-primary-container group-hover:text-secondary transition-colors font-bold line-clamp-1">{{ $producto->nombre }}</h2>
                                <p class="text-on-surface-variant font-body-sm text-xs leading-relaxed line-clamp-2">{{ $producto->descripcion ?: 'Producto del catálogo comercial.' }}</p>
                                <div class="mt-auto pt-space-md flex flex-col gap-2 border-t border-surface-container-high/40">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-on-surface-variant">Precio:</span>
                                        <span class="text-primary-container font-extrabold font-title-lg">${{ number_format($producto->precio_venta_actual, 2) }} <span class="text-xs font-normal text-on-surface-variant">USD</span></span>
                                    </div>
                                    <a href="https://wa.me/59167673537?text=Hola%20deseo%20consultar%20por%20{{ urlencode($producto->nombre) }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="w-full py-2.5 rounded-xl bg-surface-container-low text-primary-container hover:bg-emerald-600 hover:text-white font-title-md text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-all shadow-xs hover:shadow-md cursor-pointer group/wa">
                                        <svg class="w-4 h-4 text-emerald-600 group-hover/wa:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
                                        </svg>
                                        <span>Consultar por WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Mensaje de estado cuando no hay resultados de búsqueda -->
                <div id="emptyCatalog" class="rounded-2xl bg-surface-container-lowest p-space-2xl text-center shadow-sm border border-surface-container-high/40 animate-fade-in" style="display: {{ count($productos) === 0 ? 'block' : 'none' }}" role="status">
                    <div class="w-16 h-16 rounded-full bg-blue-50 text-secondary flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-[32px]" aria-hidden="true">search_off</span>
                    </div>
                    <h2 class="font-headline-sm text-headline-sm text-primary-container font-bold">No hay productos que coincidan</h2>
                    <p class="text-on-surface-variant text-sm mt-1 max-w-sm mx-auto">Prueba buscando con otro término o seleccionando una categoría diferente.</p>
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de página reutilizable -->
    @include('partials.footer')

    {{-- Botón flotante para volver arriba --}}
    <button id="backToTopCatalog"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 flex items-center justify-center rounded-full bg-surface-container-lowest shadow-lg border border-surface-container-high/60 text-secondary hover:bg-secondary hover:text-on-secondary transition-all hover:shadow-xl hover:scale-105 active:scale-95 cursor-pointer opacity-0 translate-y-4 pointer-events-none"
        aria-label="Volver arriba" title="Volver arriba"
        onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar/ocultar botón volver arriba de forma suave
            const backToTopBtn = document.getElementById('backToTopCatalog');
            if (backToTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 220) {
                        backToTopBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                        backToTopBtn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        backToTopBtn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    }
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
