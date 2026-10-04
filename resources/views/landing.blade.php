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
    $categorias = [
        [
            'id'     => 'perfumeria',
            'nombre' => 'Perfumería Femenina & Masculina',
            'desc'   => 'Eau de Parfum, colonias y aromas icónicos Natura.',
            'imagen' => asset('images/demo/productos/kaiak.jpg'),
            'badge'  => 'Perfumería',
            'slug'   => 'perfumeria',
        ],
        [
            'id'     => 'facial',
            'nombre' => 'Cuidado Facial & Antiedad',
            'desc'   => 'Tratamientos concentrados y soluciones Chronos.',
            'imagen' => asset('images/demo/productos/chronos.jpg'),
            'badge'  => 'Chronos',
            'slug'   => 'cuidado-facial',
        ],
        [
            'id'     => 'maquillaje',
            'nombre' => 'Maquillaje & Belleza',
            'desc'   => 'Bases, labiales y máscaras de pestañas.',
            'imagen' => asset('images/demo/productos/ilia.jpg'),
            'badge'  => 'Una & Faces',
            'slug'   => 'maquillaje',
        ],
        [
            'id'     => 'corporal',
            'nombre' => 'Cuidado Corporal & Baño',
            'desc'   => 'Jabones, cremas Tododia y aceites Ekos.',
            'imagen' => asset('images/demo/productos/tododia.jpg'),
            'badge'  => 'Tododia & Ekos',
            'slug'   => 'cuidado-corporal',
        ],
    ];

    $productos = [
        [
            'nombre'    => 'Kaiak Océano Desodorante Colonia 100ml',
            'linea'     => 'Perfumería Masculina',
            'categoria' => 'perfumeria',
            'desc'      => 'Notas acuáticas frescas y maderas nobles. Envase con plástico reciclado.',
            'imagen'    => asset('images/demo/productos/kaiak.jpg'),
            'tag'       => 'Natura',
        ],
        [
            'nombre'    => 'Ilía Secreto Feminino 50ml',
            'linea'     => 'Perfumería Femenina',
            'categoria' => 'perfumeria',
            'desc'      => 'Flor de azahar, uva silvestre y notas amaderadas de alta fijación.',
            'imagen'    => asset('images/demo/productos/ilia.jpg'),
            'tag'       => 'Natura',
        ],
        [
            'nombre'    => 'Chronos Suero Reductor de Arrugas 30ml',
            'linea'     => 'Cuidado Facial',
            'categoria' => 'facial',
            'desc'      => 'Triple acción restauradora con prebióticos de jatobá y biosacáridos.',
            'imagen'    => asset('images/demo/productos/chronos.jpg'),
            'tag'       => 'Natura Chronos',
        ],
        [
            'nombre'    => 'Tododia Crema Nutritiva Corporal 400ml',
            'linea'     => 'Cuidado Corporal',
            'categoria' => 'corporal',
            'desc'      => 'Nutrición prebiótica con aceite de linaza y manteca de cacao pura.',
            'imagen'    => asset('images/demo/productos/tododia.jpg'),
            'tag'       => 'Natura Tododia',
        ],
    ];
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
                                    <span class="px-space-sm py-0.5 rounded-full bg-surface-container-highest text-primary-container font-label-sm text-label-sm uppercase tracking-wider">Natura</span>
                                    <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-secondary/10 text-secondary font-label-sm text-label-sm">
                                        Destacado
                                    </span>
                                </div>
                                {{-- 1.14: draggable=false + select-none --}}
                                <div class="relative h-64 w-full flex items-center justify-center my-space-xs overflow-hidden rounded-lg bg-surface-container-lowest">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 select-none" draggable="false" alt="Natura Ilía Secreto" src="{{ asset('images/demo/productos/ilia.jpg') }}"/>
                                </div>
                                <div class="z-10 mt-space-sm">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Perfumería Femenina</span>
                                    <h2 class="font-title-lg text-title-lg text-primary-container mt-0.5">Ilía Secreto Feminino</h2>
                                    <div class="flex items-baseline gap-space-xs mt-space-xs">
                                        <span class="font-headline-sm text-headline-sm text-secondary">Precio a consultar</span>
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
                        <button class="filter-chip px-space-md py-1.5 rounded-full bg-surface-container-low text-primary-container hover:bg-surface-container font-label-md text-label-md whitespace-nowrap transition-colors" data-cat="perfumeria">
                            Perfumería
                        </button>
                        <button class="filter-chip px-space-md py-1.5 rounded-full bg-surface-container-low text-primary-container hover:bg-surface-container font-label-md text-label-md whitespace-nowrap transition-colors" data-cat="facial">
                            Cuidado Facial
                        </button>
                        <button class="filter-chip px-space-md py-1.5 rounded-full bg-surface-container-low text-primary-container hover:bg-surface-container font-label-md text-label-md whitespace-nowrap transition-colors" data-cat="corporal">
                            Cuidado Corporal
                        </button>
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
                    @foreach($productos as $prod)
                    <div class="product-item finora-card-interactive rounded-2xl bg-surface-container-lowest p-space-md shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group border border-surface-container-high/40 hover:border-secondary/40 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-secondary focus-visible:ring-offset-2"
                        role="button"
                        tabindex="0"
                        aria-label="Ver detalles de {{ $prod['nombre'] }}"
                        data-cat="{{ $prod['categoria'] }}"
                        data-nombre="{{ $prod['nombre'] }}"
                        data-linea="{{ $prod['linea'] }}"
                        data-desc="{{ $prod['desc'] }}"
                        data-imagen="{{ $prod['imagen'] }}"
                        data-tag="{{ $prod['tag'] }}"
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
                                <span class="font-headline-sm text-headline-sm text-primary-container font-bold">Precio a consultar</span>
                            </div>
                            <a href="https://wa.me/59167673537?text=Hola%20deseo%20consultar%20por%20{{ urlencode($prod['nombre']) }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()" class="w-full py-2.5 rounded-xl bg-surface-container-low text-primary-container hover:bg-emerald-600 hover:text-white font-title-md text-sm flex items-center justify-center gap-2 transition-all shadow-xs hover:shadow-md cursor-pointer group/wa">
                                <svg class="w-4 h-4 text-emerald-600 group-hover/wa:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
                                </svg>
                                <span>Consultar por WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
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
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                        Navega entre las principales líneas del catálogo Natura con atención directa de tu consultor.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    @foreach($categorias as $cat)
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
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-surface-container-high/40 pt-4 mt-2">
                    <div>
                        <span class="text-xs text-on-surface-variant block">Consultar precio actual:</span>
                        <span class="font-headline-sm text-headline-sm text-primary-container font-extrabold">A consultar</span>
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

    {{-- Botones flotantes (Back to top + WhatsApp directo) --}}
    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none" id="floating-buttons">
        {{-- Back to top --}}
        <button id="backToTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="w-12 h-12 flex items-center justify-center rounded-full bg-surface-container-lowest shadow-lg border border-surface-container-high/60 text-secondary hover:bg-secondary hover:text-on-secondary transition-all hover:shadow-xl hover:scale-105 active:scale-95 cursor-pointer"
            aria-label="Volver arriba" title="Volver arriba">
            <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
        </button>
        {{-- WhatsApp directo --}}
        <button id="aiChatBtn"
            class="w-12 h-12 flex items-center justify-center rounded-full bg-emerald-600 hover:bg-emerald-700 shadow-lg text-white hover:scale-105 active:scale-95 transition-all hover:shadow-xl cursor-pointer"
            aria-label="WhatsApp Consultor" title="Chatear con el consultor"
            onclick="window.open('https://wa.me/59167673537?text=Hola%2C%20necesito%20informaci%C3%B3n%20sobre%20productos%20Natura','_blank')">
            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
            </svg>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const heroPhrase = document.querySelector('.hero-gradient-text');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

            if (heroPhrase && !reduceMotion.matches) {
                const phrases = [
                    'Descubre algo que te guste.',
                    'Descubre algo que te fascine.',
                    'Descubre tu fragancia ideal.',
                    'Encuentra tu próximo favorito.'
                ];
                let phraseIndex = 0;

                window.setInterval(() => {
                    heroPhrase.classList.add('hero-phrase-changing');

                    window.setTimeout(() => {
                        phraseIndex = (phraseIndex + 1) % phrases.length;
                        heroPhrase.textContent = phrases[phraseIndex];
                        heroPhrase.classList.remove('hero-phrase-changing');
                    }, 280);
                }, 4800);
            }

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
                document.getElementById('modalTag').textContent = card.dataset.tag;
                document.getElementById('modalLinea').textContent = card.dataset.linea;
                document.getElementById('modalNombre').textContent = card.dataset.nombre;
                document.getElementById('modalDesc').textContent = card.dataset.desc;
                document.getElementById('modalWaLink').href =
                    'https://wa.me/59167673537?text=Hola%20deseo%20consultar%20por%20' + encodeURIComponent(card.dataset.nombre);
                modal.showModal();
            };

            // Cerrar modal al clicar en backdrop
            const productModal = document.getElementById('productModal');
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