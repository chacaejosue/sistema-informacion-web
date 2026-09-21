<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Panel del Consultor | Sistema de Gestión Comercial y Financiera</title>

    <!-- Favicon de Finora -->
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>

    <!-- Tipografías de Google: Outfit & Manrope -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

    <!-- Iconos Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    <!-- Carga de estilos y scripts del proyecto mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy flex flex-col min-h-screen">

    <!-- Barra de navegación superior (Header) -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">

            <!-- Logo e Isotipo de Finora -->
            <a class="inline-flex items-center gap-3.5 group" href="{{ route('panel') }}" title="Finora - Panel Principal">
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform"/>
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                    <span class="text-[10px] font-medium text-finora-subtle -mt-1 tracking-wide">Panel del Consultor</span>
                </div>
            </a>

            <!-- Área de usuario y cierre de sesión -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-bold text-finora-navy">
                        {{ $usuario->persona->nombre }} {{ $usuario->persona->apellido }}
                    </span>
                    <span class="text-[11px] font-medium text-finora-subtle">
                        {{ $usuario->persona->email }}
                    </span>
                </div>

                <!-- Insignia de rol -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-finora-blue text-xs font-bold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-finora-blue"></span>
                    {{ $usuario->rol }}
                </span>

                <!-- Formulario de cierre de sesión -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-red-600 hover:bg-red-50 border border-slate-200 hover:border-red-200 transition-colors cursor-pointer" title="Cerrar sesión">
                        <span class="material-symbols-outlined text-base">logout</span>
                        <span class="hidden sm:inline">Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Contenido principal del panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        <!-- Banner de bienvenida -->
        <section aria-labelledby="welcome-title" class="bg-gradient-to-r from-finora-navy via-finora-dark to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden mb-10">
            <!-- Detalle decorativo de fondo -->
            <div aria-hidden="true" class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>
            <div aria-hidden="true" class="absolute right-32 -bottom-20 w-72 h-72 rounded-full bg-blue-500/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-cyan-300 text-xs font-bold tracking-wide uppercase mb-4">
                    <span class="material-symbols-outlined text-sm">verified_user</span>
                    Sesión Activa
                </div>

                <h1 id="welcome-title" class="font-heading text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    ¡Bienvenido, {{ $usuario->persona->nombre }}!
                </h1>

                <p class="mt-3 text-slate-300 text-sm sm:text-base leading-relaxed font-normal">
                    Este es tu espacio privado de gestión en Finora. Desde aquí podrás administrar el catálogo de productos, compras, inventario, pedidos de clientes, ventas y flujo financiero.
                </p>
            </div>
        </section>

        <!-- Sección de estructura modular del sistema -->
        <section aria-labelledby="modules-title" class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 id="modules-title" class="font-heading text-xl sm:text-2xl font-extrabold text-finora-navy tracking-tight">
                        Módulos de Gestión
                    </h2>
                    <p class="text-xs sm:text-sm text-finora-subtle font-medium mt-0.5">
                        Estructura comercial y financiera configurada para tu cuenta de consultor.
                    </p>
                </div>
            </div>

            <!-- Cuadrícula con la estructura visual de los 6 módulos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Módulo 1: Productos (Activo) -->
                <a href="{{ route('panel.productos.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-finora-blue group-hover:bg-finora-blue group-hover:text-white transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">package_2</span>
                            </div>
                            <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Módulo Activo
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-finora-blue transition-colors flex items-center gap-1">
                            <span>Productos</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Gestión del catálogo de productos, proveedores, líneas, categorías, precios y publicaciones.
                        </p>
                    </div>
                </a>

                <!-- Módulo 2: Compras -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                                En preparación
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy">Compras</h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Registro de pedidos de reabastecimiento y recepción de productos de proveedores.
                        </p>
                    </div>
                </div>

                <!-- Módulo 3: Inventario -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">inventory_2</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                                En preparación
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy">Inventario</h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Control de existencias, stock disponible, asignaciones y movimientos de almacén.
                        </p>
                    </div>
                </div>

                <!-- Módulo 4: Pedidos -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                                En preparación
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy">Pedidos</h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Seguimiento de pedidos solicitados por los clientes y estados de entrega.
                        </p>
                    </div>
                </div>

                <!-- Módulo 5: Ventas -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">point_of_sale</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                                En preparación
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy">Ventas</h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Registro de ventas directas, condiciones de pago y comprobantes para clientes.
                        </p>
                    </div>
                </div>

                <!-- Módulo 6: Finanzas -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">account_balance</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                                En preparación
                            </span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy">Finanzas</h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Control de cuentas por cobrar, cuotas de créditos, cobros y salud financiera del negocio.
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Pie de página del panel -->
    <footer class="bg-white border-t border-slate-200/80 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-finora-subtle">
            <div class="flex items-center gap-2">
                <span class="font-bold text-finora-navy">Finora</span>
                <span>&mdash; Sistema de gestión comercial y financiera para consultores independientes</span>
            </div>
            <div>
                &copy; {{ date('Y') }} Finora. Todos los derechos reservados.
            </div>
        </div>
    </footer>

</body>
</html>
