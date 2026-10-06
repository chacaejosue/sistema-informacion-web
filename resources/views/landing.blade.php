<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Catálogo Online</title>
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 1.8: Animaciones suaves de entrada --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.55s ease both;
        }
        .animate-fade-in-up-d1 { animation-delay: 0.1s; }
        .animate-fade-in-up-d2 { animation-delay: 0.2s; }
        .animate-fade-in-up-d3 { animation-delay: 0.3s; }
        .animate-fade-in-up-d4 { animation-delay: 0.4s; }
        html { scroll-behavior: smooth; }
    </style>
</head>
{{-- 1.17: Fondo más contrastado con border entre secciones --}}
<body class="bg-[#F4F7FB] font-body-md text-body-md text-on-surface min-h-screen relative selection:bg-secondary selection:text-on-secondary">

    <!-- Encabezado -->
    @include('partials.header')

    @php
        $productoDestacado = $productos->first();
        $categoriasLanding = $categorias->map(fn ($categoria) => [
            'nombre' => $categoria->nombre,
            'desc' => $categoria->descripcion ?: 'Productos disponibles en nuestro catálogo.',
            'imagen' => $categoria->productos->first()?->imagen_url ?: asset('images/branding/finora-icono.png'),
            'badge' => $categoria->nombre,
            'slug' => \Illuminate\Support\Str::slug($categoria->nombre),
        ]);
        $productosLanding = $productos->map(fn ($producto) => [
            'id' => $producto->id,
            'codigo' => $producto->codigo,
            'nombre' => $producto->nombre,
            'linea' => $producto->linea?->nombre ?: 'Catálogo general',
            'categoria' => \Illuminate\Support\Str::slug($producto->categoria->nombre),
            'categoriaNombre' => $producto->categoria->nombre,
            'desc' => $producto->descripcion ?: 'Producto disponible para consulta.',
            'imagen' => $producto->imagen_url ?: asset('images/branding/finora-icono.png'),
            'tag' => $producto->proveedor?->nombre ?: 'Producto',
            'precio' => $producto->precio_venta_actual,
        ]);
    @endphp

    <!-- Contenido principal -->
    <main class="relative z-10 w-full pt-20 bg-transparent min-h-[calc(100vh-320px)]">
        <div class="flex flex-col w-full overflow-hidden relative">
            <!-- Presentación principal (1.8: con animación fade-in-up) -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin pt-space-xl lg:pt-space-2xl pb-space-2xl w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                    <!-- Texto e información principal -->
                    <div class="lg:col-span-6 flex flex-col gap-space-md animate-fade-in-up">
                        <div class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded-full bg-surface-container-lowest shadow-sm w-fit">
                            <span class="w-2 h-2 rounded-full bg-gradient-to-r from-secondary to-[#00D2DF] animate-pulse"></span>
                            <span class="font-label-md text-label-md text-primary-container tracking-tight whitespace-nowrap sm:hidden">Productos Natura · Consultor</span>
                            <span class="hidden sm:inline font-label-md text-label-md text-primary-container tracking-tight whitespace-nowrap">Productos Natura • Atención de un consultor independiente</span>
                        </div>
                        <h1 class="font-display-lg text-display-lg text-primary-container leading-[1.08] tracking-tight">
                            Encuentra lo que buscas. <br class="hidden sm:inline"/>
                            <span class="hero-gradient-text bg-clip-text text-transparent" aria-live="polite">
                                Descubre algo que te guste.
                            </span>
                        </h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl leading-relaxed">
                            Explora la variedad de fragancias, cuidado personal y cosméticos Natura con atención directa de tu consultor independiente de confianza.
                        </p>
                        <div class="flex flex-wrap items-center gap-space-md pt-space-xs">
                            <a class="inline-flex items-center gap-space-xs px-space-xl py-3.5 rounded-xl bg-gradient-to-r from-secondary-container via-secondary to-[#0052cc] text-on-secondary font-title-md text-title-md shadow-[0_8px_20px_rgba(2,102,255,0.28)] hover:shadow-[0_12px_28px_rgba(2,102,255,0.38)] hover:-translate-y-0.5 active:translate-y-0 transition-all" href="#catalogo-destacados">
                                <span>Explorar catálogo</span>
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    <!-- Producto destacado en tarjeta (1.8: con animación retrasada) -->
                    <div class="lg:col-span-6 relative mt-space-lg lg:mt-0 animate-fade-in-up animate-fade-in-up-d2">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary-container/20 via-[#00D2DF]/15 to-transparent rounded-full filter blur-3xl scale-95 pointer-events-none"></div>
                        <div class="relative w-full rounded-2xl bg-surface-container-lowest/80 backdrop-blur-md shadow-xl p-space-lg">
                            <div class="flex flex-col justify-between p-space-lg rounded-xl bg-gradient-to-b from-surface-container-low to-surface-container-lowest shadow-sm relative overflow-hidden group">
                                <div class="flex items-center justify-between gap-space-sm z-10 mb-space-sm">
                            <span id="heroProductProvider" class="px-space-sm py-0.5 rounded-full bg-surface-container-highest text-primary-container font-label-sm text-label-sm uppercase tracking-wider">{{ $productoDestacado?->proveedor?->nombre ?? 'Catálogo' }}</span>
                                    <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-secondary/10 text-secondary font-label-sm text-label-sm">
                                        Destacado
                                    </span>
                                </div>
                                {{-- 1.14: draggable=false + select-none --}}
                                <div class="relative h-64 w-full flex items-center justify-center my-space-xs overflow-hidden rounded-lg bg-surface-container-lowest">
                                    <img id="heroProductImage" class="w-full h-full object-cover group-hover:scale-105 active:scale-105 transition-all duration-500 select-none" draggable="false" alt="{{ $productoDestacado?->nombre ?? 'Producto destacado' }}" src="{{ $productoDestacado?->imagen_url ?: asset('images/branding/finora-icono.png') }}"/>
                                </div>
                                <div class="z-10 mt-space-sm">
                                    <span id="heroProductLine" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">{{ $productoDestacado?->linea?->nombre ?? 'Catálogo comercial' }}</span>
                                    <h2 id="heroProductName" class="font-title-lg text-title-lg text-primary-container mt-0.5">{{ $productoDestacado?->nombre ?? 'Productos registrados por el consultor' }}</h2>
                                    <div class="flex items-baseline gap-space-xs mt-space-xs">
                                        <span id="heroProductPrice" data-money-bob="{{ $productoDestacado?->precio_venta_actual ?? 0 }}" class="font-headline-sm text-headline-sm text-secondary">@money($productoDestacado?->precio_venta_actual)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 1.16: Sección de productos destacados AHORA está DEBAJO del buscador --}}

            <!-- Buscador y filtro por categoría -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin -mt-space-sm mb-space-xl w-full">
                {{-- 1.17: Borde y sombra más marcada para separar secciones --}}
                <div class="p-space-lg rounded-2xl bg-surface-container-lowest shadow-md border border-surface-container-high/60 flex flex-col gap-space-md">
                    <div class="relative flex items-center w-full">
                        <span class="material-symbols-outlined absolute left-4 text-on-surface-variant text-[24px]">search</span>
                        <input class="w-full h-14 pl-14 pr-32 rounded-xl bg-surface-container-low text-primary-container placeholder:text-on-surface-variant font-body-lg text-body-lg focus:outline-none focus:bg-surface-container-lowest focus:shadow-[0_0_0_2px_#0266ff] transition-all" id="catalog-search" placeholder="Buscar por producto o categoría (ej. Ilía, Chronos, Kaiak)..." type="text"/>
                        <button class="absolute right-2 px-space-md py-2.5 rounded-lg bg-secondary text-on-secondary font-title-md text-title-md hover:bg-secondary-container transition-all" id="search-btn">
                            Buscar
                        </button>
                    </div>
                    <div class="flex items-center gap-space-xs overflow-x-auto pb-1 scrollbar-none">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap mr-2">Categorías:</span>
                        <button class="filter-chip active px-space-md py-1.5 rounded-full bg-secondary text-on-secondary font-label-md text-label-md whitespace-nowrap shadow-sm transition-colors" data-cat="all">
                            Todas
                        </button>
                        @foreach ($categoriasLanding as $categoria)
                            <button class="filter-chip px-space-md py-1.5 rounded-full bg-surface-container-low text-primary-container hover:bg-surface-container font-label-md text-label-md whitespace-nowrap transition-colors" data-cat="{{ $categoria['slug'] }}">
                                {{ $categoria['nombre'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- 1.16: Sección de productos destacados movida aquí (antes estaba después de categorías) --}}
            <!-- Sección de productos disponibles -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin mb-space-2xl w-full" id="catalogo-destacados">
                <div class="mb-space-lg flex flex-col sm:flex-row sm:items-end justify-between gap-2 pb-2 border-b border-surface-container-high/50">
                    <div>
                        <span class="text-secondary font-label-sm text-label-sm uppercase tracking-wider font-semibold">Catálogo Natura</span>
                        <h2 class="font-headline-lg text-headline-lg text-primary-container mt-1">Productos destacados</h2>
                    </div>
                    <span class="text-xs text-on-surface-variant font-medium">Atención y pedidos por WhatsApp</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md" id="products-container">
                    @foreach($productosLanding as $prod)
                    <div class="product-item finora-card-interactive rounded-2xl bg-surface-container-lowest p-space-md shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group border border-surface-container-high/40 hover:border-secondary/40 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-secondary focus-visible:ring-offset-2"
                        role="button"
                        tabindex="0"
                        aria-label="Ver detalles de {{ $prod['nombre'] }}"
                        data-cat="{{ $prod['categoria'] }}"
                        data-codigo="{{ $prod['codigo'] }}"
                        data-categoria-nombre="{{ $prod['categoriaNombre'] }}"
                        data-nombre="{{ $prod['nombre'] }}"
                        data-linea="{{ $prod['linea'] }}"
                        data-desc="{{ $prod['desc'] }}"
                        data-imagen="{{ $prod['imagen'] }}"
                        data-tag="{{ $prod['tag'] }}"
                        data-precio="{{ $prod['precio'] }}"
                        onclick="openProductModal(this)"
                        onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openProductModal(this); }">
                        <div>
                            <div class="relative h-56 w-full rounded-xl overflow-hidden bg-surface-container-low mb-space-sm flex items-center justify-center">
                                <img class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 select-none" draggable="false" alt="{{ $prod['nombre'] }}" src="{{ $prod['imagen'] }}" onerror="this.onerror=null; this.src='{{ asset('images/branding/finora-icono.png') }}';"/>
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-md bg-surface-container-lowest/95 backdrop-blur-sm text-primary-container font-label-sm text-label-sm uppercase font-semibold shadow-xs">{{ $prod['tag'] }}</span>
                                <div class="absolute inset-0 bg-gradient-to-t from-primary-container/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-3">
                                    <span class="text-[11px] font-bold text-white bg-black/60 px-3 py-1 rounded-full backdrop-blur-xs flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span> Ver detalle
                                    </span>
                                </div>
                            </div>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">{{ $prod['linea'] }}</span>
                            <h3 class="font-title-lg text-title-lg text-primary-container mt-1 line-clamp-1 group-hover:text-secondary transition-colors">{{ $prod['nombre'] }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2 leading-relaxed">{{ $prod['desc'] }}</p>
                        </div>
                        <div class="pt-space-md mt-space-sm border-t border-surface-container">
                            <div class="flex items-baseline gap-space-xs mb-space-sm">
                                <span data-money-bob="{{ $prod['precio'] }}" class="font-headline-sm text-headline-sm text-primary-container font-bold">@money($prod['precio'])</span>
                            </div>
                            <button type="button" data-add-product="{{ $prod['id'] }}" data-cart-url="{{ route('carrito') }}" onclick="event.stopPropagation(); window.finoraAddProduct(this)" class="w-full py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 font-title-md text-sm flex items-center justify-center gap-2 transition-all shadow-xs hover:shadow-md cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                                <span>Agregar al carrito</span>
                            </button>
                            <a href="{{ config('services.whatsapp.phone') ? 'https://wa.me/' . preg_replace('/\D+/', '', config('services.whatsapp.phone')) . '?text=' . urlencode('Hola deseo consultar por ' . $prod['nombre']) : '#' }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()" class="mt-2 w-full py-2.5 rounded-xl bg-surface-container-low text-primary-container hover:bg-emerald-600 hover:text-white font-title-md text-sm flex items-center justify-center gap-2 transition-all shadow-xs hover:shadow-md cursor-pointer group/wa">
                                <svg class="w-4 h-4 text-emerald-600 group-hover/wa:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
                                </svg>
                                <span>Consultar por WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    <div id="landingEmptyCatalog" class="hidden col-span-full rounded-2xl bg-surface-container-lowest p-space-2xl text-center shadow-sm border border-surface-container-high/40" role="status">
                        <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-secondary dark:bg-blue-950/60">
                            <span class="material-symbols-outlined text-[32px]" aria-hidden="true">search_off</span>
                        </div>
                        <h2 class="font-headline-sm text-headline-sm text-primary-container font-bold">No encontramos productos</h2>
                        <p id="landingEmptyMessage" class="text-on-surface-variant text-sm mt-1 max-w-lg mx-auto">Prueba con otro nombre o selecciona una categoría diferente.</p>
                    </div>
                </div>
            </section>

            <!-- Sección de categorías -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin mb-space-2xl w-full border-t border-surface-container-high/50 pt-space-2xl" id="categorias">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-space-lg gap-space-xs">
                    <div>
                        <div class="inline-flex items-center gap-space-xs text-secondary font-label-sm text-label-sm uppercase tracking-wider font-semibold mb-1">
                            <span class="material-symbols-outlined text-[16px]">category</span>
                            <span>Líneas de productos</span>
                        </div>
                        <h2 class="font-headline-lg text-headline-lg text-primary-container">Explora por categoría</h2>
                    </div>
                     <p class="font-body-md text-body-md text-on-surface-variant max-w-md sm:max-w-none">
                        <span class="sm:whitespace-nowrap">Navega entre las principales líneas del catálogo Natura con atención directa de tu consultor.</span>
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    @foreach($categoriasLanding as $cat)
                    <a class="group finora-card-interactive relative rounded-2xl bg-surface-container-lowest p-space-md shadow-sm hover:shadow-xl transition-all flex flex-col justify-between overflow-hidden border border-surface-container-high/40 hover:border-secondary/40" href="{{ route('categorias', ['categoria' => $cat['slug']]) }}">
                        <div class="relative h-44 w-full rounded-xl overflow-hidden bg-surface-container-low mb-space-md">
                            <img class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 select-none" draggable="false" alt="{{ $cat['nombre'] }}" src="{{ $cat['imagen'] }}" onerror="this.onerror=null; this.src='{{ asset('images/branding/finora-icono.png') }}';"/>
                            <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md bg-surface-container-lowest/90 backdrop-blur-sm text-secondary font-label-sm text-label-sm font-semibold shadow-xs">{{ $cat['badge'] }}</span>
                        </div>
                        <div>
                            <h3 class="font-title-lg text-title-lg text-primary-container group-hover:text-secondary transition-colors">{{ $cat['nombre'] }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">{{ $cat['desc'] }}</p>
                        </div>
                        <div class="mt-space-md flex items-center justify-between text-secondary font-title-md text-sm font-semibold pt-2 border-t border-surface-container/60">
                            <span>Ver catálogo</span>
                            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1.5 transition-transform">arrow_forward</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de página -->
    @include('partials.footer')

    {{-- Modal de detalles de producto mejorado con animación --}}
    <dialog id="productModal" aria-labelledby="modalNombre" aria-describedby="modalDesc" class="fixed inset-0 m-auto w-full max-w-lg rounded-3xl bg-surface-container-lowest shadow-2xl p-0 border border-surface-container-high/50 backdrop:bg-black/60 backdrop:backdrop-blur-xs animate-scale-up">
        <div class="flex flex-col max-h-[90vh]">
            <div class="relative h-72 w-full rounded-t-3xl overflow-hidden bg-surface-container-low shrink-0">
                 <img id="modalImage" src="" alt="" class="w-full h-full object-cover select-none" draggable="false"/>
                 <div class="absolute bottom-3.5 left-3.5 inline-flex items-center gap-1 rounded-xl bg-surface-container-lowest/90 p-1 shadow-md backdrop-blur-md">
                     <button id="modalZoomOut" type="button" class="flex h-9 w-9 items-center justify-center rounded-lg text-primary-container hover:bg-surface-container" aria-label="Reducir imagen"><span class="material-symbols-outlined">zoom_out</span></button>
                     <button id="modalZoomReset" type="button" class="flex h-9 items-center justify-center rounded-lg px-2 text-xs font-bold text-primary-container hover:bg-surface-container" aria-label="Restablecer zoom">100%</button>
                     <button id="modalZoomIn" type="button" class="flex h-9 w-9 items-center justify-center rounded-lg text-primary-container hover:bg-surface-container" aria-label="Ampliar imagen"><span class="material-symbols-outlined">zoom_in</span></button>
                 </div>
                <button onclick="document.getElementById('productModal').close()" class="absolute top-3.5 right-3.5 w-10 h-10 flex items-center justify-center rounded-full bg-surface-container-lowest/90 backdrop-blur-md text-on-surface hover:bg-surface-container hover:scale-105 active:scale-95 transition-all shadow-md cursor-pointer" aria-label="Cerrar">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
                <span id="modalTag" class="absolute top-3.5 left-3.5 px-3 py-1 rounded-lg bg-surface-container-lowest/90 backdrop-blur-md text-secondary font-label-sm text-xs uppercase font-bold shadow-xs"></span>
            </div>
            <div class="p-6 flex flex-col gap-4 overflow-y-auto">
                <div>
                    <span id="modalLinea" class="font-label-sm text-label-sm text-secondary uppercase tracking-wider font-semibold"></span>
                    <h3 id="modalNombre" class="font-headline-sm text-headline-sm text-primary-container mt-1 font-bold"></h3>
                    <p id="modalDesc" class="font-body-md text-body-md text-on-surface-variant mt-2 leading-relaxed"></p>
                </div>
                <dl class="grid grid-cols-2 gap-3 rounded-2xl bg-surface-container-low p-4 text-sm">
                    <div><dt class="text-on-surface-variant">Código</dt><dd id="modalCodigo" class="font-bold text-primary-container"></dd></div>
                    <div><dt class="text-on-surface-variant">Categoría</dt><dd id="modalCategoria" class="font-bold text-primary-container"></dd></div>
                    <div><dt class="text-on-surface-variant">Proveedor</dt><dd id="modalProveedor" class="font-bold text-primary-container"></dd></div>
                    <div><dt class="text-on-surface-variant">Precio</dt><dd id="modalPrecio" class="font-bold text-primary-container"></dd></div>
                </dl>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-surface-container-high/40 pt-4 mt-2">
                    <div>
                         <span class="text-xs text-on-surface-variant block">Precio de referencia</span>
                         <span class="font-headline-sm text-headline-sm text-primary-container font-extrabold">Verifica disponibilidad con el consultor</span>
                    </div>
                    <a id="modalWaLink" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-title-md text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
                        </svg>
                        <span>Consultar por WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </dialog>

    {{-- Botón flotante para volver arriba --}}
    <div class="fixed bottom-24 right-6 z-50 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none" id="floating-buttons">
        {{-- Back to top --}}
        <button id="backToTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="w-12 h-12 flex items-center justify-center rounded-full bg-surface-container-lowest shadow-lg border border-surface-container-high/60 text-secondary hover:bg-secondary hover:text-on-secondary transition-all hover:shadow-xl hover:scale-105 active:scale-95 cursor-pointer"
            aria-label="Volver arriba" title="Volver arriba">
            <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
        </button>
    </div>

    {{-- Asistente de compra: visible permanentemente y separado de volver arriba --}}
    <div id="aiChatLauncher" class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
        <span id="aiChatPrompt" class="inline-flex max-w-[13rem] rounded-2xl border border-secondary/20 bg-surface-container-lowest px-3 py-2 text-xs font-bold text-primary-container shadow-lg transition-all duration-500 sm:max-w-none sm:px-4 sm:py-2.5 sm:text-sm">
            ¿Necesitas ayuda para elegir?
        </span>
        <button id="aiChatBtn"
            class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary text-white shadow-xl ring-4 ring-secondary/15 hover:bg-secondary-container hover:scale-105 active:scale-95 transition-all cursor-pointer"
             aria-label="Asistente de compra" title="¿Qué deseas comprar?"
             onclick="document.getElementById('aiChatDialog').showModal()">
            <span class="material-symbols-outlined text-2xl">support_agent</span>
        </button>
    </div>

    <dialog id="aiChatDialog" class="fixed inset-0 m-auto w-[min(92vw,28rem)] rounded-3xl bg-surface-container-lowest p-0 shadow-2xl backdrop:bg-black/50">
        <div class="flex max-h-[80vh] flex-col">
            <div class="flex items-center justify-between border-b border-surface-container-high p-5">
                <div><p class="text-xs font-bold uppercase tracking-wider text-secondary">Asistente Finora</p><h2 class="text-lg font-bold text-primary-container">¿Qué deseas comprar?</h2></div>
                <button type="button" onclick="document.getElementById('aiChatDialog').close()" class="rounded-full p-2 hover:bg-surface-container" aria-label="Cerrar"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div id="aiChatMessages" class="flex flex-col gap-3 overflow-y-auto p-5 text-sm"></div>
            <div id="aiChatOptions" class="flex flex-wrap gap-2 border-t border-surface-container-high p-5"></div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

            const heroProducts = @json($productosLanding->values());
            const heroImage = document.getElementById('heroProductImage');
            if (heroImage && heroProducts.length > 1 && !reduceMotion.matches) {
                let heroIndex = 0;
                window.setInterval(() => {
                    heroIndex = (heroIndex + 1) % heroProducts.length;
                    const product = heroProducts[heroIndex];
                    heroImage.classList.add('opacity-0');
                    window.setTimeout(() => {
                        heroImage.src = product.imagen;
                        heroImage.alt = product.nombre;
                        document.getElementById('heroProductProvider').textContent = product.tag;
                        document.getElementById('heroProductLine').textContent = product.linea;
                        document.getElementById('heroProductName').textContent = product.nombre;
                        document.getElementById('heroProductPrice').textContent = `Bs ${Number(product.precio).toLocaleString('es-BO', {minimumFractionDigits: 2})}`;
                        heroImage.classList.remove('opacity-0');
                    }, 300);
                }, 4200);
            }

            if (window.matchMedia('(pointer: coarse)').matches) {
                document.querySelectorAll('.product-item, .catalog-product').forEach(card => {
                    card.addEventListener('pointerdown', () => {
                        card.classList.add('touch-zoom');
                        window.setTimeout(() => card.classList.remove('touch-zoom'), 550);
                    }, { passive: true });
                });
            }

            const chatMessages = document.getElementById('aiChatMessages');
            const chatOptions = document.getElementById('aiChatOptions');
            if (chatMessages && chatOptions) {
                    const categories = [...new Map(heroProducts.map(product => [product.categoria, product.categoriaNombre])).entries()];
                const addMessage = (text, user = false) => {
                    const message = document.createElement('p');
                     message.className = user ? 'finora-chat-message self-end rounded-2xl rounded-br-sm bg-secondary px-4 py-2 text-white' : 'finora-chat-message self-start max-w-[90%] rounded-2xl rounded-bl-sm bg-surface-container-low px-4 py-2 text-primary-container';
                     message.textContent = text;
                     chatMessages.appendChild(message);
                     window.requestAnimationFrame(() => { chatMessages.scrollTo({top: chatMessages.scrollHeight, behavior: 'smooth'}); });
                };
                let assistantIsTyping = false;
                const waitForAssistant = async () => {
                    assistantIsTyping = true;
                    chatOptions.innerHTML = '';
                    const typing = document.createElement('div');
                    typing.className = 'finora-typing self-start rounded-2xl rounded-bl-sm bg-surface-container-low px-4 py-3';
                    typing.innerHTML = '<span></span><span></span><span></span>';
                    chatMessages.appendChild(typing);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    await new Promise(resolve => window.setTimeout(resolve, 1800));
                    typing.remove();
                    assistantIsTyping = false;
                };
                const options = (items, callback) => {
                    chatOptions.innerHTML = '';
                    items.forEach(item => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'rounded-full border border-secondary/30 px-3 py-2 text-xs font-bold text-secondary hover:bg-secondary hover:text-white';
                        button.textContent = item.label;
                        button.onclick = async () => {
                            if (assistantIsTyping) return;
                            await callback(item.value, item.label);
                        };
                        chatOptions.appendChild(button);
                    });
                };
                const startChat = () => {
                    chatMessages.innerHTML = '';
                    addMessage('¡Hola! Soy el asistente de Finora. Te ayudaré a encontrar algo ideal. ¿Qué categoría te interesa?');
                    options(categories.map(([value, label]) => ({value, label})), async (category, label) => {
                        addMessage(label, true);
                        await waitForAssistant();
                        addMessage('¿Tienes algún producto específico en mente?');
                        const categoryProducts = heroProducts.filter(product => product.categoria === category);
                        options([{value: '', label: 'Cualquiera'}, ...categoryProducts.slice(0, 8).map(product => ({value: product.nombre, label: product.nombre}))], async (productName, productLabel) => {
                            addMessage(productLabel, true);
                            await waitForAssistant();
                            addMessage('¿Qué rango de precio prefieres?');
                            options([{value: 20, label: 'Hasta Bs 20'}, {value: 40, label: 'Hasta Bs 40'}, {value: 80, label: 'Hasta Bs 80'}, {value: 9999, label: 'Cualquier precio'}], async (max, priceLabel) => {
                                addMessage(priceLabel, true);
                                await waitForAssistant();
                                const found = heroProducts.filter(product => product.categoria === category && (!productName || product.nombre === productName) && Number(product.precio) <= max).slice(0, 4);
                                addMessage(found.length ? `Encontré ${found.length} opción(es): ${found.map(product => product.nombre).join(', ')}.` : 'No encontré coincidencias. Puede estar en otra categoría o no estar disponible.');
                                options([{value: 'restart', label: 'Buscar otra vez'}, {value: 'consultor', label: 'Hablar con el consultor'}], value => {
                                    if (value === 'restart') startChat();
                                    else window.open('https://wa.me/{{ preg_replace('/\D+/', '', config('services.whatsapp.phone')) }}?text=Hola%2C%20necesito%20ayuda%20para%20elegir%20un%20producto', '_blank');
                                });
                            });
                        });
                    });
                };
                document.getElementById('aiChatBtn')?.addEventListener('click', startChat);
            }

            const chatPrompt = document.getElementById('aiChatPrompt');
            const chatLauncher = document.getElementById('aiChatLauncher');
            const hidePrompt = () => chatPrompt?.classList.add('pointer-events-none', 'translate-x-3', 'opacity-0');
            const showPrompt = () => chatPrompt?.classList.remove('pointer-events-none', 'translate-x-3', 'opacity-0');
            window.setTimeout(hidePrompt, 8000);
            window.setInterval(() => {
                showPrompt();
                window.setTimeout(hidePrompt, 6000);
            }, 30000);
            chatLauncher?.querySelector('button')?.addEventListener('click', hidePrompt);

            // Mostrar botones flotantes de forma suave
            const floatingBtns = document.getElementById('floating-buttons');
            if (floatingBtns) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 220) {
                        floatingBtns.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                        floatingBtns.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    } else {
                        floatingBtns.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        floatingBtns.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    }
                }, { passive: true });
            }

            // Modal de producto
            window.openProductModal = function(card) {
                const modal = document.getElementById('productModal');
                if (!modal) return;
                document.getElementById('modalImage').src = card.dataset.imagen;
                document.getElementById('modalImage').alt = card.dataset.nombre;
                document.getElementById('modalImage').classList.remove('scale-150', 'cursor-zoom-out', 'object-contain');
                document.getElementById('modalImage').classList.add('cursor-zoom-in', 'object-cover');
                document.getElementById('modalImage').style.transform = 'scale(1)';
                document.getElementById('modalTag').textContent = card.dataset.tag;
                document.getElementById('modalLinea').textContent = card.dataset.linea;
                document.getElementById('modalNombre').textContent = card.dataset.nombre;
                document.getElementById('modalDesc').textContent = card.dataset.desc;
                document.getElementById('modalCodigo').textContent = card.dataset.codigo || 'No registrado';
                document.getElementById('modalCategoria').textContent = card.dataset.categoriaNombre || 'Catálogo general';
                document.getElementById('modalProveedor').textContent = card.dataset.tag || 'No registrado';
                document.getElementById('modalPrecio').textContent = card.dataset.precio ? `Bs ${Number(card.dataset.precio).toLocaleString('es-BO', {minimumFractionDigits: 2})}` : 'A consultar';
                document.getElementById('modalWaLink').href =
                    'https://wa.me/{{ preg_replace('/\D+/', '', config('services.whatsapp.phone')) }}?text=Hola%20deseo%20consultar%20por%20' + encodeURIComponent(card.dataset.nombre);
                modal.showModal();
            };

            // Cerrar modal al clicar en backdrop
            const productModal = document.getElementById('productModal');
            const modalImage = document.getElementById('modalImage');
            let modalZoom = 1;
            const updateModalZoom = () => {
                modalImage.style.transform = `scale(${modalZoom})`;
                modalImage.classList.toggle('cursor-zoom-out', modalZoom > 1);
                modalImage.classList.toggle('cursor-zoom-in', modalZoom === 1);
                document.getElementById('modalZoomReset').textContent = `${Math.round(modalZoom * 100)}%`;
            };
            document.getElementById('modalZoomIn')?.addEventListener('click', () => {
                modalZoom = Math.min(2.5, modalZoom + 0.25);
                updateModalZoom();
            });
            document.getElementById('modalZoomOut')?.addEventListener('click', () => {
                modalZoom = Math.max(1, modalZoom - 0.25);
                updateModalZoom();
            });
            document.getElementById('modalZoomReset')?.addEventListener('click', () => {
                modalZoom = 1;
                updateModalZoom();
            });
            modalImage?.addEventListener('wheel', event => {
                event.preventDefault();
                modalZoom = Math.min(2.5, Math.max(1, modalZoom + (event.deltaY < 0 ? 0.25 : -0.25)));
                updateModalZoom();
            }, { passive: false });
            if (productModal) {
                productModal.addEventListener('click', (e) => {
                    const rect = productModal.getBoundingClientRect();
                    if (e.clientX < rect.left || e.clientX > rect.right ||
                        e.clientY < rect.top  || e.clientY > rect.bottom) {
                        productModal.close();
                    }
                });
            }
        });
    </script>
</body>
</html>
