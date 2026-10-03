<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Panel Principal | Sistema de Gestión Comercial y Financiera</title>

    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy flex flex-col min-h-screen">

    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a class="inline-flex items-center gap-3.5 group" href="{{ route('panel') }}" title="Finora - Panel Principal">
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform"/>
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                    <span class="text-[10px] font-medium text-finora-subtle -mt-1 tracking-wide">Panel Administrativo</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-bold text-finora-navy">
                        {{ $usuario->persona->nombre }} {{ $usuario->persona->apellido }}
                    </span>
                    <span class="text-[11px] font-medium text-finora-subtle">
                        {{ $usuario->persona->email }}
                    </span>
                </div>

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-finora-blue text-xs font-bold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-finora-blue"></span>
                    {{ $usuario->rol }}
                </span>

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

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        <section aria-labelledby="welcome-title" class="bg-gradient-to-r from-finora-navy via-finora-dark to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden mb-10">
            <div aria-hidden="true" class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>
            <div aria-hidden="true" class="absolute right-32 -bottom-20 w-72 h-72 rounded-full bg-blue-500/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-cyan-300 text-xs font-bold tracking-wide uppercase mb-4">
                    <span class="material-symbols-outlined text-sm">verified_user</span>
                    Sesión Activa
                </div>

                <h1 id="welcome-title" class="font-heading text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    ¡{{ $usuario->persona->saludo }}, {{ $usuario->persona->nombre }}!
                </h1>

                <p class="mt-3 text-slate-300 text-sm sm:text-base leading-relaxed font-normal">
                    {{ $usuario->persona->saludo }} a Finora. Gestiona el flujo comercial completo de tu negocio: catálogo de productos, clientes, pedidos, compras, inventario, ventas y cobranzas.
                </p>
            </div>
        </section>

        <section aria-labelledby="modules-title" class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 id="modules-title" class="font-heading text-xl sm:text-2xl font-extrabold text-finora-navy tracking-tight">
                        Módulos del Sistema
                    </h2>
                    <p class="text-xs sm:text-sm text-finora-subtle font-medium mt-0.5">
                        Selecciona un módulo operativo para gestionar la información.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1. Productos -->
                <a href="{{ route('panel.productos.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-finora-blue group-hover:bg-finora-blue group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">package_2</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-finora-blue transition-colors flex items-center gap-1">
                            <span>Productos</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Catálogo de productos, precios y publicación.
                        </p>
                    </div>
                </a>

                <!-- 2. Clientes -->
                <a href="{{ route('panel.clientes.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">group</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-emerald-600 transition-colors flex items-center gap-1">
                            <span>Clientes</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Directorio de clientes y personas de contacto.
                        </p>
                    </div>
                </a>

                <!-- 3. Pedidos -->
                <a href="{{ route('panel.pedidos.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-purple-600 transition-colors flex items-center gap-1">
                            <span>Pedidos</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Solicitudes de clientes y reservas de stock.
                        </p>
                    </div>
                </a>

                <!-- 4. Compras -->
                <a href="{{ route('panel.compras.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-700 group-hover:bg-cyan-700 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-cyan-700 transition-colors flex items-center gap-1">
                            <span>Compras</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Reabastecimiento y recepción de mercadería.
                        </p>
                    </div>
                </a>

                <!-- 5. Inventario -->
                <a href="{{ route('panel.inventario.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">inventory_2</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-amber-600 transition-colors flex items-center gap-1">
                            <span>Inventario</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Existencias, reservaciones y kárdex de almacén.
                        </p>
                    </div>
                </a>

                <!-- 6. Ventas -->
                <a href="{{ route('panel.ventas.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">point_of_sale</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-rose-600 transition-colors flex items-center gap-1">
                            <span>Ventas</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Facturación, salidas de stock y cobro directo.
                        </p>
                    </div>
                </a>

                <!-- 7. Créditos y Pagos -->
                <a href="{{ route('panel.pagos.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-2xl">account_balance</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-indigo-600 transition-colors flex items-center gap-1">
                            <span>Créditos / Pagos</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </h3>
                        <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                            Cuentas por cobrar y registro de abonos.
                        </p>
                    </div>
                </a>

                <!-- 8. Usuarios -->
                @if ($usuario->rol === 'CONSULTOR')
                    <a href="{{ route('panel.usuarios.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-finora-blue transition-all flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 group-hover:bg-slate-800 group-hover:text-white transition-colors flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-2xl">manage_accounts</span>
                            </div>
                            <h3 class="font-heading text-lg font-bold text-finora-navy group-hover:text-slate-800 transition-colors flex items-center gap-1">
                                <span>Usuarios</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </h3>
                            <p class="text-xs text-finora-subtle mt-1.5 leading-relaxed">
                                Administración de cuentas de acceso y roles.
                            </p>
                        </div>
                    </a>
                @endif

            </div>
        </section>

    </main>

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
