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
</head>
<body class="bg-background font-body-md text-body-md text-on-surface min-h-screen relative selection:bg-secondary selection:text-on-secondary">
    <div class="pointer-events-none fixed inset-0 overflow-hidden z-0">
        <svg class="absolute -right-24 top-16 w-[620px] h-[620px] text-secondary opacity-[0.035]" fill="currentColor" viewBox="0 0 200 200">
            <path d="M45,20 C85,15 160,25 155,65 C152,90 120,95 105,96 L105,120 C125,119 140,126 138,145 C136,165 110,175 75,178 L45,180 Z M65,45 L65,80 L115,80 C128,80 135,74 135,62 C135,50 125,45 112,45 Z M65,108 L65,155 L100,154 C115,153 122,148 122,135 C122,122 112,110 95,108 Z"></path>
        </svg>
        <svg class="absolute -left-36 bottom-32 w-[540px] h-[540px] text-secondary-container opacity-[0.03]" fill="currentColor" viewBox="0 0 200 200">
            <path d="M50,15 L160,15 L160,50 L95,50 L95,85 L145,85 L145,120 L95,120 L95,185 L50,185 Z"></path>
        </svg>
    </div>

    <!-- Encabezado -->
    <header class="fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-20 max-w-7xl mx-auto px-space-md lg:px-margin flex items-center justify-between">
            <div class="flex items-center gap-space-lg">
                <a class="flex items-center gap-space-sm group" data-path="inicio" href="#">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform"/>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-headline-md text-headline-md text-primary-container tracking-tight">Finora</span>
                            <span class="px-space-xs py-[2px] rounded-lg bg-surface-container-low text-secondary font-label-sm text-label-sm uppercase tracking-wider">Catálogo Online</span>
                        </div>
                    </div>
                </a>
                <nav class="hidden lg:flex items-center gap-space-lg pl-space-md">
                    <a class="transition-colors text-secondary font-title-md" data-path="inicio" href="#">Inicio</a>
                    <a class="text-on-surface-variant hover:text-on-surface font-title-md text-title-md transition-colors" data-path="catalogo" href="#catalogo-destacados">Catálogo</a>
                    <a class="text-on-surface-variant hover:text-on-surface font-title-md text-title-md transition-colors" data-path="categorias" href="#categorias">Categorías</a>
                </nav>
            </div>
            <div class="flex items-center gap-space-md">
                <a class="inline-flex items-center justify-center px-space-lg py-space-sm rounded-lg bg-gradient-to-r from-secondary-container to-secondary text-on-secondary font-title-md text-title-md shadow-[0_4px_14px_rgba(2,102,255,0.28)] hover:opacity-95 active:scale-98 transition-all" data-path="login" href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        </div>
    </header>

    @php
    $categorias = [
        [
            'id' => 'perfumeria',
            'nombre' => 'Perfumería Femenina & Masculina',
            'desc' => 'Eau de Parfum, colonias y aromas icónicos Natura.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBxcMsNQZSIsdb4okFDAE0gH6L38ZSmYwnegAajpDZkU3wNTEecLWFDF5s8kwxoRvoSEJ8FU61o3Z3keP8EV3jHh_ZW3UimcmZEmALLpBHlxNy_SwUfo0AVJP9LJ_5rYRCyFCncW6Ih7w2V6col1QZKy4RKFAf74WgzZ5ycjd7gtjWuCYaqfmXmIpLlF-bWIrS4BVHJa8rKqKy1BvdFOIASHO5fkGj6n7I-Lcz11Y31dHFmZ-TcEYaZ',
            'badge' => 'Perfumería'
        ],
        [
            'id' => 'facial',
            'nombre' => 'Cuidado Facial & Antiedad',
            'desc' => 'Tratamientos concentrados y soluciones Chronos.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfzFhlpmnUmECDoLj3Sx2gh1Sb7o8VHuaTUknOb-uYYl3tgyRfp36zOh6B8rv3YYSCZ4Gj_EuqXb4SmQH_dSNX0w0eP8cX_b3SL3dS7sOzMkGZGYUkKud7xcXTSOLVRTy910YDZzwFY16dKstT8ekXktw-xSY5TyZfJRLVRCdRZcBawTx53cC9r1amTXBxu5CIf-Sa-tT-aeO-v4pss9sErJYo2NhYIVvLcZh_X_wKBT947W37tGoa',
            'badge' => 'Chronos'
        ],
        [
            'id' => 'maquillaje',
            'nombre' => 'Maquillaje & Belleza',
            'desc' => 'Bases, labiales y máscaras de pestañas.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKPr7vwaXaN_76XxZd9Uw90OQibqotJwPA83NEt2kG1tWJR6sqbZJZ_OMxvBFn9xgqQfhMDKtOKacZVVTRkqPzP37sfHcZyOJOBwcvx3VZd3UZgxhvGtDQYI2efmeOvuuoxot1z8XJocfYjDjFIlokdd1awwqALXqnATQUbNqFLIoBd-n0CPMZk7JjQjWcJzWTHDcJ7CYcwBo1OwOqksWhlmeSCX1865nad6W4kFHsEhgILALWlNHg',
            'badge' => 'Una & Faces'
        ],
        [
            'id' => 'corporal',
            'nombre' => 'Cuidado Corporal & Baño',
            'desc' => 'Jabones, cremas Tododia y aceites Ekos.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCW-t4D8b-e08Wp--r_kFgodviBu3FXXd9lRfxRXMHqgAKTYNLIjdBGpdmIeosVIjZvqhLg4ol61ibFrDC2QUKOQMLVSc_SpixPw_GxqsVpl0bK1zDlzGZefPjDc7QxCZgimSLep795dwU5qx9e1beoylRxdCJ7-pl0GKDmCwy-6R1-i4-wBfWgivRQgdodmrOD7OXGj_PGZSd8MvIJboIT9wxDtmG_ZJnJktm4laAn0FKnWH6GnxL5',
            'badge' => 'Tododia & Ekos'
        ]
    ];

    $productos = [
        [
            'nombre' => 'Kaiak Océano Desodorante Colonia 100ml',
            'linea' => 'Perfumería Masculina',
            'categoria' => 'perfumeria',
            'desc' => 'Notas acuáticas frescas y maderas nobles. Envase con plástico reciclado.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCk__CamhCJuxGhETjCqsE2JudDCh8CN_iwlinQiN3aIIOplZeRcRlNrMOLe-f0-2QSymYReONH8aMIB68TEKqyIZ_XVP2Ozi0hXDonhJ_7I2vLQThNCLzSHG2LG9ksIbA1hJUM5kRX08tbCrV9y1sf15OdFM_cj9LhcmaFux2q1S1SV-CY87BnZIWmZR_E4K1nwk74OsCqFXfIxc5vChNgEDSF4An75eZDS6qpoJp3nQ5ujqNCMloY',
            'tag' => 'Natura'
        ],
        [
            'nombre' => 'Ilía Secreto Feminino 50ml',
            'linea' => 'Perfumería Femenina',
            'categoria' => 'perfumeria',
            'desc' => 'Flor de azahar, uva silvestre y notas amaderadas de alta fijación.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBGQDcagPGRPv26ZXYqBUpy1xtl8i8sQOw0jULAVrNGr5bfvBityPnrSyoQ2P_hIX7hSgUH3gMioOjQA2jfC-TGFjHYSh_ZglEcKpRZ8ejSfiTMBAfq7ImNd1RcZvOphZJuf3Qd6BRSsqUQgLmD6mgbx6AUFzRqwHFiONXmpAa-cbvOxkiZkaEG9_bYmHPS2CRFghGZ08peALOG0Qm4Vmelh6hwy0sqJ-W53L-nyYLMN2UoewIEDnLp',
            'tag' => 'Natura'
        ],
        [
            'nombre' => 'Chronos Suero Reductor de Arrugas 30ml',
            'linea' => 'Cuidado Facial',
            'categoria' => 'facial',
            'desc' => 'Triple acción restauradora con prebióticos de jatobá y biosacáridos.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD4Vt2uuv1rAezUkBlX2gIWPSLv5ll-AvG2axrBg6GGyfrh01MQoymj7KQj_J3LK9k3wJTeDMak0tdPmM35h2psxAomfjlwpi7jJNl6TcwE91DOz0htAKRz2hjVy9JOu_iQz75xHAqbkKy_Px2jUwJwAvlOPmE1JsHOb_BlnXUhyNrByuBDAoIflaRsI93_wME_ZtZtytjIYXgIgCvVX12yvbPXTOCkVLCLziM7MXaTfw5XwnGBOTAU',
            'tag' => 'Natura Chronos'
        ],
        [
            'nombre' => 'Tododia Crema Nutritiva Corporal 400ml',
            'linea' => 'Cuidado Corporal',
            'categoria' => 'corporal',
            'desc' => 'Nutrición prebiótica con aceite de linaza y manteca de cacao pura.',
            'imagen' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD2ewDuGKijoiEOiuHiIBxb7zF6rG3_F-H9yoE5uNk1TpRmKtNeO8x5MZax3Awol8sWTIU_cc3JmU3SR7sJ1wSJb9l3R-1FDGNIm_qh5hzfp8KsSOj0VftJT0AJ6mLcKM7Upr5znkMBl5hFz43WgjLiVkRIP0Gzmt3txvE-GcakDYlKigiI49wJiIN9lksUeV_LUb_iOL18ADb3CKZee36WhO8ei6mC_3wgoLTuAUirPyRsdO2knW7c',
            'tag' => 'Natura Tododia'
        ]
    ];
    @endphp

    <!-- Contenido principal -->
    <main class="relative z-10 w-full pt-20 bg-transparent min-h-[calc(100vh-320px)]">
        <div class="flex flex-col w-full overflow-hidden relative">
            <!-- Fondos decorativos -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
                <div class="absolute -top-40 right-[-10%] w-[820px] h-[820px] rounded-full bg-gradient-to-br from-secondary-container/10 via-[#00D2DF]/10 to-transparent blur-[140px]"></div>
                <div class="absolute top-[45%] -left-48 w-[640px] h-[640px] rounded-full bg-gradient-to-tr from-secondary/5 via-primary-fixed/30 to-transparent blur-[120px]"></div>
                <div class="absolute bottom-20 right-[-5%] w-[680px] h-[680px] rounded-full bg-gradient-to-tl from-[#00D2DF]/8 via-secondary-container/5 to-transparent blur-[130px]"></div>
            </div>

            <!-- Presentación principal -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin pt-space-xl lg:pt-space-2xl pb-space-2xl w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                    <!-- Texto e información principal -->
                    <div class="lg:col-span-6 flex flex-col gap-space-md">
                        <div class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded-full bg-surface-container-lowest shadow-sm w-fit">
                            <span class="w-2 h-2 rounded-full bg-gradient-to-r from-secondary to-[#00D2DF] animate-pulse"></span>
                            <span class="font-label-md text-label-md text-primary-container tracking-tight">Productos Natura • Atención de un consultor independiente</span>
                        </div>
                        <h1 class="font-display-lg text-display-lg text-primary-container leading-[1.08] tracking-tight">
                            Encuentra lo que buscas. <br class="hidden sm:inline"/>
                            <span class="bg-gradient-to-r from-secondary via-secondary-container to-[#00B4D8] bg-clip-text text-transparent">
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
                    <!-- Producto destacado en tarjeta -->
                    <div class="lg:col-span-6 relative mt-space-lg lg:mt-0">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary-container/20 via-[#00D2DF]/15 to-transparent rounded-full filter blur-3xl scale-95 pointer-events-none"></div>
                        <div class="relative w-full rounded-2xl bg-surface-container-lowest/80 backdrop-blur-md shadow-xl p-space-lg">
                            <div class="flex flex-col justify-between p-space-lg rounded-xl bg-gradient-to-b from-surface-container-low to-surface-container-lowest shadow-sm relative overflow-hidden group">
                                <div class="flex items-center justify-between gap-space-sm z-10 mb-space-sm">
                                    <span class="px-space-sm py-0.5 rounded-full bg-surface-container-highest text-primary-container font-label-sm text-label-sm uppercase tracking-wider">Natura</span>
                                    <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-secondary/10 text-secondary font-label-sm text-label-sm">
                                        Destacado
                                    </span>
                                </div>
                                <div class="relative h-64 w-full flex items-center justify-center my-space-xs overflow-hidden rounded-lg bg-surface-container-lowest">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Natura Ilía Secreto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBGQDcagPGRPv26ZXYqBUpy1xtl8i8sQOw0jULAVrNGr5bfvBityPnrSyoQ2P_hIX7hSgUH3gMioOjQA2jfC-TGFjHYSh_ZglEcKpRZ8ejSfiTMBAfq7ImNd1RcZvOphZJuf3Qd6BRSsqUQgLmD6mgbx6AUFzRqwHFiONXmpAa-cbvOxkiZkaEG9_bYmHPS2CRFghGZ08peALOG0Qm4Vmelh6hwy0sqJ-W53L-nyYLMN2UoewIEDnLp"/>
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

            <!-- Buscador y filtro por categoría -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin -mt-space-sm mb-space-2xl w-full">
                <div class="p-space-lg rounded-2xl bg-surface-container-lowest shadow-md flex flex-col gap-space-md">
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

            <!-- Sección de categorías -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin mb-space-2xl w-full" id="categorias">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-space-lg gap-space-xs">
                    <div>
                        <div class="inline-flex items-center gap-space-xs text-secondary font-label-sm text-label-sm uppercase tracking-wider mb-1">
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
                    <a class="group relative rounded-2xl bg-surface-container-lowest p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden" href="#catalogo-destacados">
                        <div class="relative h-44 w-full rounded-xl overflow-hidden bg-surface-container-low mb-space-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $cat['nombre'] }}" src="{{ $cat['imagen'] }}"/>
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-surface-container-lowest/90 backdrop-blur-sm text-secondary font-label-sm text-label-sm">{{ $cat['badge'] }}</span>
                        </div>
                        <div>
                            <h3 class="font-title-lg text-title-lg text-primary-container group-hover:text-secondary transition-colors">{{ $cat['nombre'] }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $cat['desc'] }}</p>
                        </div>
                        <div class="mt-space-md flex items-center justify-between text-secondary font-title-md text-title-md">
                            <span>Ver catálogo</span>
                            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">east</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>

            <!-- Sección de productos destacados -->
            <section class="relative z-10 max-w-7xl mx-auto px-space-md lg:px-margin mb-space-2xl w-full" id="catalogo-destacados">
                <div class="mb-space-lg">
                    <span class="text-secondary font-label-sm text-label-sm uppercase tracking-wider">Catálogo Natura</span>
                    <h2 class="font-headline-lg text-headline-lg text-primary-container">Productos destacados</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md" id="products-container">
                    @foreach($productos as $prod)
                    <div class="product-item rounded-2xl bg-surface-container-lowest p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between group" data-cat="{{ $prod['categoria'] }}">
                        <div>
                            <div class="relative h-56 w-full rounded-xl overflow-hidden bg-surface-container-low mb-space-sm flex items-center justify-center">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $prod['nombre'] }}" src="{{ $prod['imagen'] }}"/>
                                <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md bg-surface-container-lowest text-primary-container font-label-sm text-label-sm uppercase">{{ $prod['tag'] }}</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">{{ $prod['linea'] }}</span>
                            <h3 class="font-title-lg text-title-lg text-primary-container mt-1 line-clamp-1">{{ $prod['nombre'] }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">{{ $prod['desc'] }}</p>
                        </div>
                        <div class="pt-space-md mt-space-sm border-t border-surface-container">
                            <div class="flex items-baseline gap-space-xs mb-space-sm">
                                <span class="font-headline-sm text-headline-sm text-primary-container font-bold">Precio a consultar</span>
                            </div>
                            <a href="https://wa.me/?text=Hola%20deseo%20consultar%20por%20{{ urlencode($prod['nombre']) }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 rounded-lg bg-surface-container text-primary-container hover:bg-secondary hover:text-on-secondary font-title-md text-title-md flex items-center justify-center gap-space-xs transition-all">
                                <span class="material-symbols-outlined text-[18px]">chat</span>
                                <span>Consultar por WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="relative z-10 w-full bg-surface-container-low mt-space-2xl">
        <div class="max-w-7xl mx-auto px-space-md lg:px-margin pt-space-2xl pb-space-xl">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-space-xl">
                <div class="lg:col-span-5 flex flex-col gap-space-md">
                    <div class="flex items-center gap-space-sm">
                        <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-8 w-auto object-contain"/>
                        <span class="font-headline-sm text-headline-sm text-primary-container">Finora</span>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-sm">
                        Plataforma de gestión comercial y catálogo digital para consultor independiente Natura.
                    </p>
                </div>
                <div class="lg:col-span-3 flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-on-surface">Categorías</h3>
                    <ul class="flex flex-col gap-space-xs font-body-md text-body-md text-on-surface-variant">
                        <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="#categorias">Perfumería</a></li>
                        <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="#categorias">Cuidado Facial</a></li>
                        <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="#categorias">Maquillaje</a></li>
                        <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="#categorias">Cuidado Corporal</a></li>
                    </ul>
                </div>
                <div class="lg:col-span-4 flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-on-surface">Asistencia Directa</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">¿Tienes dudas sobre algún producto? Chatea directamente con tu consultor.</p>
                    <a class="inline-flex items-center justify-center gap-space-xs px-space-md py-space-sm rounded-lg bg-surface-container-lowest text-on-surface hover:bg-surface-container hover:text-on-surface font-title-md text-title-md shadow-[0_2px_8px_-2px_rgba(11,25,44,0.04)] transition-all" data-path="contacto-consultor" href="https://wa.me/?text=Hola%20deseo%20consultar%20el%20cat%C3%A1logo%20Finora" target="_blank" rel="noopener noreferrer">
                        <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                        WhatsApp Consultor
                    </a>
                </div>
            </div>
            <div class="mt-space-2xl pt-space-md flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container-highest/60">
                <p class="font-body-sm text-body-sm text-on-surface-variant text-center sm:text-left">Finora © {{ date('Y') }} - Catálogo digital para consultor independiente Natura. Todos los derechos reservados.</p>
                <div class="flex items-center gap-space-lg font-body-sm text-body-sm text-on-surface-variant">
                    <a class="hover:text-on-surface transition-colors" data-path="aviso-privacidad" href="#">Aviso de privacidad</a>
                    <a class="hover:text-on-surface transition-colors" data-path="terminos-servicio" href="#">Términos de servicio</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts para el buscador y filtros -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productItems = document.querySelectorAll('.product-item');
            const filterChips = document.querySelectorAll('.filter-chip');
            const searchInput = document.getElementById('catalog-search');

            let currentCategory = 'all';
            let searchQuery = '';

            function updateVisibility() {
                productItems.forEach(item => {
                    const catMatch = currentCategory === 'all' || item.getAttribute('data-cat') === currentCategory;
                    const textMatch = !searchQuery || item.innerText.toLowerCase().includes(searchQuery);

                    if (catMatch && textMatch) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            filterChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    filterChips.forEach(c => {
                        c.classList.remove('bg-secondary', 'text-on-secondary', 'shadow-sm', 'active');
                        c.classList.add('bg-surface-container-low', 'text-primary-container');
                    });
                    chip.classList.add('bg-secondary', 'text-on-secondary', 'shadow-sm', 'active');
                    chip.classList.remove('bg-surface-container-low', 'text-primary-container');

                    currentCategory = chip.getAttribute('data-cat') || 'all';
                    updateVisibility();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    searchQuery = e.target.value.toLowerCase().trim();
                    updateVisibility();
                });
            }
        });
    </script>
</body>
</html>