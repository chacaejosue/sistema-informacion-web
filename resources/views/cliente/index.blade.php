<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Mi Cuenta | Portal de Cliente</title>

    <!-- Favicon de Finora -->
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>

    <!-- Tipografías de Google: Outfit & Manrope -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

    <!-- Iconos Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a class="inline-flex items-center gap-3.5 group" href="{{ route('landing') }}" title="Finora - Inicio">
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform"/>
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                    <span class="text-[10px] font-medium text-finora-subtle -mt-1 tracking-wide">Mi Cuenta &bull; Portal de Cliente</span>
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

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 border border-cyan-200 text-cyan-800 text-xs font-bold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
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

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        <!-- Banner de Bienvenida -->
        <section aria-labelledby="welcome-title" class="bg-gradient-to-r from-finora-navy via-finora-dark to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
            <div aria-hidden="true" class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>
            <div aria-hidden="true" class="absolute right-32 -bottom-20 w-72 h-72 rounded-full bg-blue-500/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-cyan-300 text-xs font-bold tracking-wide uppercase mb-4">
                    <span class="material-symbols-outlined text-sm">person</span>
                    Espacio del Cliente
                </div>

                <h1 id="welcome-title" class="font-heading text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    ¡Bienvenido, {{ $usuario->persona->nombre }}!
                </h1>

                <p class="mt-3 text-slate-300 text-sm sm:text-base leading-relaxed font-normal">
                    Gracias por confiar en Finora. Este es tu panel de cliente donde próximamente podrás realizar el seguimiento de tus pedidos, consultar estados de cuenta y gestionar tus preferencias.
                </p>
            </div>
        </section>

        <!-- Tarjeta Principal de Estado en Desarrollo -->
        <section class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm text-center space-y-6">
            <div class="w-16 h-16 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center mx-auto border border-cyan-100 shadow-sm">
                <span class="material-symbols-outlined text-3xl">construction</span>
            </div>

            <div class="max-w-xl mx-auto">
                <h2 class="font-heading text-xl sm:text-2xl font-extrabold text-finora-navy">
                    Portal de Cliente en Desarrollo
                </h2>
                <p class="text-xs sm:text-sm text-finora-subtle mt-2 leading-relaxed">
                    Estamos trabajando en nuevas herramientas exclusivas para ti. Mientras tanto, puedes explorar nuestro catálogo público de productos.
                </p>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('categorias') }}" class="finora-gradient-btn px-6 py-3 rounded-xl text-white font-heading font-semibold text-xs shadow-finora-btn inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">storefront</span>
                    Explorar Catálogo de Productos
                </a>
            </div>
        </section>

        <!-- Secciones Próximas (Tarjetas de vista previa) -->
        <!-- Secciones Próximas (Tarjetas de vista previa) -->
        <section aria-labelledby="upcoming-title" class="space-y-4">
            <h3 id="upcoming-title" class="font-heading text-lg font-bold text-finora-navy">
                Funcionalidades Próximas
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Próxima 1: Mis Pedidos -->
                <div class="finora-card-interactive bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 shadow-xs">
                            <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                        </div>
                        <h4 class="font-heading text-base font-bold text-finora-navy flex items-center justify-between">
                            <span>Mis Pedidos</span>
                            <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2 py-0.5 rounded-full">Próximamente</span>
                        </h4>
                        <p class="text-xs text-finora-subtle mt-2 leading-relaxed">
                            Consulta el estado en tiempo real de tus solicitudes y fechas estimadas de entrega.
                        </p>
                    </div>
                </div>

                <!-- Próxima 2: Estado de Cuenta -->
                <div class="finora-card-interactive bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 shadow-xs">
                            <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
                        </div>
                        <h4 class="font-heading text-base font-bold text-finora-navy flex items-center justify-between">
                            <span>Estado de Cuenta</span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">Próximamente</span>
                        </h4>
                        <p class="text-xs text-finora-subtle mt-2 leading-relaxed">
                            Historial de compras a crédito, saldos pendientes y comprobantes de abonos.
                        </p>
                    </div>
                </div>

                <!-- Próxima 3: Promociones Natura -->
                <div class="finora-card-interactive bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 shadow-xs">
                            <span class="material-symbols-outlined text-2xl">local_offer</span>
                        </div>
                        <h4 class="font-heading text-base font-bold text-finora-navy flex items-center justify-between">
                            <span>Promociones</span>
                            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Próximamente</span>
                        </h4>
                        <p class="text-xs text-finora-subtle mt-2 leading-relaxed">
                            Ofertas exclusivas y descuentos recomendados por tu consultor independiente.
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-finora-subtle">
            <div class="flex items-center gap-2">
                <span class="font-bold text-finora-navy">Finora</span>
                <span>&mdash; Plataforma comercial y financiera</span>
            </div>
            <div>
                &copy; {{ date('Y') }} Finora. Todos los derechos reservados.
            </div>
        </div>
    </footer>

</body>
</html>
