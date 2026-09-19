<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Iniciar Sesión | Sistema de Gestión Comercial y Financiera</title>

    <!-- Favicon de Finora -->
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>

    <!-- Tipografías de Google: Outfit & Manrope -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

    <!-- Iconos Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    <!-- Carga de estilos y scripts del proyecto mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy">
    <!-- Contenedor principal de pantalla dividida -->
    <div class="min-h-full flex flex-col lg:flex-row">

        <!-- Panel izquierdo: Formulario de acceso seguro -->
        <main class="w-full lg:w-[48%] xl:w-[45%] flex flex-col justify-between px-6 py-8 sm:px-12 md:px-16 lg:px-14 xl:px-20 bg-white z-10 min-h-screen">

            <!-- Logotipo y marca principal -->
            <header class="w-full">
                <a class="inline-flex items-center gap-3.5 group" href="{{ route('landing') }}" title="Finora - Portal Principal">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform"/>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-heading text-2xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                        <span class="text-[11px] font-medium text-finora-subtle -mt-1 tracking-wide">Gestión comercial y financiera</span>
                    </div>
                </a>
            </header>

            <!-- Contenedor central del formulario -->
            <section aria-labelledby="login-title" class="my-auto py-8 max-w-md w-full mx-auto">
                <div class="mb-8 text-left">
                    <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-finora-navy tracking-tight" id="login-title">
                        Bienvenido a Finora
                    </h1>
                    <p class="mt-2 text-sm text-finora-subtle font-medium">
                        Ingresa a tu cuenta para continuar.
                    </p>
                </div>

                <!-- Formulario de autenticación -->
                <form action="#" class="space-y-5" method="POST" onsubmit="event.preventDefault();">
                    @csrf

                    <!-- Campo: Correo electrónico o nombre de usuario -->
                    <div>
                        <label class="block text-xs font-bold font-sans text-finora-navy mb-1.5" for="identity">
                            Correo electrónico o usuario
                        </label>
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">person</span>
                            </div>
                            <input autocomplete="username" class="block w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border border-slate-200 rounded-xl text-sm placeholder:text-slate-400 text-finora-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-finora-blue focus:border-transparent transition-all" id="identity" name="identity" placeholder="Correo electrónico o nombre de usuario" required="" type="text"/>
                        </div>
                    </div>

                    <!-- Campo: Contraseña con botón para alternar visibilidad -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold font-sans text-finora-navy" for="password">
                                Contraseña
                            </label>
                        </div>
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input autocomplete="current-password" class="block w-full pl-10 pr-11 py-3 bg-[#F8FAFC] border border-slate-200 rounded-xl text-sm placeholder:text-slate-400 text-finora-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-finora-blue focus:border-transparent transition-all" id="password" name="password" placeholder="••••••••••••" required="" type="password"/>
                            <button aria-label="Mostrar u ocultar contraseña" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-finora-navy transition-colors focus:outline-none cursor-pointer" id="togglePassword" type="button">
                                <span class="material-symbols-outlined text-[20px]" id="eyeIcon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Opción: Recordar sesión (recuperación de contraseña no implementada aún) -->
                    <div class="pt-1">
                        <label class="inline-flex items-center cursor-pointer select-none">
                            <input class="h-4 w-4 rounded border-slate-300 text-finora-blue focus:ring-finora-blue cursor-pointer" id="remember-me" name="remember-me" type="checkbox"/>
                            <span class="ml-2 text-xs font-medium text-finora-subtle">
                                Recordar mi sesión
                            </span>
                        </label>
                    </div>

                    <!-- Botón principal de acceso -->
                    <div class="pt-3">
                        <button class="finora-gradient-btn w-full py-3.5 px-6 rounded-xl text-white font-heading font-semibold text-base shadow-finora-btn flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-4 focus:ring-cyan-200" type="submit">
                            <span>Iniciar sesión</span>
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </div>
                </form>

                <!-- Enlace secundario: Volver al catálogo público (misma pestaña) -->
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-finora-subtle">
                        ¿Solo quieres explorar productos?
                        <a class="font-bold text-finora-blue hover:text-finora-deepBlue transition-colors underline decoration-slate-300 underline-offset-4 ml-1 inline-flex items-center gap-0.5" href="{{ route('landing') }}">
                            <span class="material-symbols-outlined text-xs">arrow_back</span>
                            Volver al catálogo
                        </a>
                    </p>
                </div>
            </section>

            <!-- Pie del panel de acceso -->
            <footer class="w-full pt-4 pb-2 border-t border-slate-100 flex items-center justify-center text-xs text-finora-subtle">
                <span>Finora &mdash; Sistema de gestión para consultores independientes</span>
            </footer>
        </main>

        <!-- Panel derecho: Identidad visual Finora y módulos de valor -->
        <aside aria-label="Identidad Finora" class="hidden lg:flex lg:w-[52%] xl:w-[55%] finora-soft-bg relative overflow-hidden flex-col justify-between p-12 xl:p-16 border-l border-slate-200/70">

            <!-- Emblema artístico translúcido de fondo -->
            <div aria-hidden="true" class="absolute -right-24 top-1/2 -translate-y-1/2 w-[760px] h-[760px] pointer-events-none select-none opacity-10">
                <svg class="w-full h-full" fill="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="bgArtGrad" x1="10%" x2="90%" y1="90%" y2="10%">
                            <stop offset="0%" stop-color="#0050CC"></stop>
                            <stop offset="60%" stop-color="#0062FF"></stop>
                            <stop offset="100%" stop-color="#00D2DF"></stop>
                        </linearGradient>
                        <linearGradient id="bgArtWing" x1="0%" x2="100%" y1="0%" y2="100%">
                            <stop offset="0%" stop-color="#00E5C9"></stop>
                            <stop offset="100%" stop-color="#00A3FF"></stop>
                        </linearGradient>
                    </defs>
                    <path d="M22 24C34 16 54 14 74 15C81 15.3 83 23 76 26.5C62 33 44 35 24 35C21 35 19 26 22 24Z" fill="url(#bgArtWing)"></path>
                    <path d="M20 28C22 28 24 30 24 34V68C24 75 19 75 19 68V32C19 29.5 20 28 20 28Z" fill="url(#bgArtGrad)"></path>
                    <path d="M24 42C38 38 52 38 68 42C74 43.5 73 50.5 67 52C53 55 37 56 24 57V74C24 81 16 80 16 73V35C16 31 19 28 24 28" fill="url(#bgArtGrad)"></path>
                </svg>
            </div>

            <!-- Orbes luminosos difuminados de fondo -->
            <div aria-hidden="true" class="absolute top-12 right-20 w-80 h-80 rounded-full bg-cyan-200/35 blur-3xl pointer-events-none"></div>
            <div aria-hidden="true" class="absolute bottom-16 left-12 w-96 h-96 rounded-full bg-blue-300/25 blur-3xl pointer-events-none"></div>

            <!-- Encabezado del panel derecho -->
            <div class="relative z-10 flex items-center justify-between w-full">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur-md border border-white/70 shadow-sm text-xs font-semibold text-finora-navy">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Acceso a Finora
                </div>
                <div class="text-xs font-medium text-finora-subtle">
                    Sistema web de gestión
                </div>
            </div>

            <!-- Tarjeta central de gestión integral -->
            <div class="relative z-10 my-auto py-10 max-w-lg mx-auto text-center lg:text-left w-full">
                <div class="bg-white/80 backdrop-blur-xl p-8 sm:p-10 rounded-3xl border border-white shadow-finora-card">

                    <!-- Etiqueta decorativa superior -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50/80 border border-blue-100 text-finora-blue text-xs font-bold tracking-wide uppercase mb-5">
                        <span class="material-symbols-outlined text-sm">hub</span>
                        Gestión Integral
                    </div>

                    <!-- Mensaje y propuesta de valor -->
                    <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-finora-navy tracking-tight leading-snug">
                        Tu negocio, organizado en un solo lugar.
                    </h2>
                    <p class="mt-3 text-sm sm:text-base text-finora-subtle leading-relaxed font-normal">
                        Gestiona ventas, pedidos, clientes y finanzas de forma simple con Finora.
                    </p>

                    <!-- Cuadrícula con los 4 módulos conceptuales -->
                    <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3">

                        <!-- Módulo: Ventas -->
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-finora-blue flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-lg">point_of_sale</span>
                            </div>
                            <span class="text-xs font-bold text-finora-navy">Ventas</span>
                        </div>

                        <!-- Módulo: Pedidos -->
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-lg">inventory_2</span>
                            </div>
                            <span class="text-xs font-bold text-finora-navy">Pedidos</span>
                        </div>

                        <!-- Módulo: Clientes -->
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-sky-50 text-finora-sky flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-lg">group</span>
                            </div>
                            <span class="text-xs font-bold text-finora-navy">Clientes</span>
                        </div>

                        <!-- Módulo: Finanzas -->
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-lg">account_balance</span>
                            </div>
                            <span class="text-xs font-bold text-finora-navy">Finanzas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie de página del panel derecho -->
            <div class="relative z-10 flex items-center justify-center text-xs text-finora-subtle border-t border-slate-200/50 pt-4">
                <span>Sistema de gestión comercial para consultores independientes</span>
            </div>
        </aside>
    </div>

    {{-- La interacción de contraseña se maneja en resources/js/app.js --}}
</body>
</html>
