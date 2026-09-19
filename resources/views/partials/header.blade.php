<!-- Encabezado principal de Finora -->
<header class="fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="h-20 max-w-7xl mx-auto px-space-md lg:px-margin flex items-center justify-between">
        <!-- Logotipo e identidad de marca -->
        <div class="flex items-center gap-space-lg">
            <a class="flex items-center gap-space-sm group" data-path="inicio" href="{{ route('landing') }}">
                <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform"/>
                <div class="flex flex-col">
                    <div class="flex items-center gap-space-xs">
                        <span class="font-headline-md text-headline-md text-primary-container tracking-tight">Finora</span>
                        <span class="px-space-xs py-[2px] rounded-lg bg-surface-container-low text-secondary font-label-sm text-label-sm uppercase tracking-wider">Catálogo Online</span>
                    </div>
                </div>
            </a>

            <!-- Navegación principal del sitio -->
            <nav class="hidden lg:flex items-center gap-space-lg pl-space-md">
                <a class="transition-colors {{ request()->routeIs('landing') ? 'text-secondary font-title-md' : 'text-on-surface-variant hover:text-on-surface font-title-md text-title-md' }}" data-path="inicio" href="{{ route('landing') }}">Inicio</a>
                <a class="text-on-surface-variant hover:text-on-surface font-title-md text-title-md transition-colors" data-path="catalogo" href="{{ route('landing') }}#catalogo-destacados">Catálogo</a>
                <a class="transition-colors {{ request()->routeIs('categorias') ? 'text-secondary font-title-md' : 'text-on-surface-variant hover:text-on-surface font-title-md text-title-md' }}" data-path="categorias" href="{{ route('categorias') }}">Categorías</a>
            </nav>
        </div>

        <!-- Botón de acceso a inicio de sesión -->
        <div class="flex items-center gap-space-md">
            <a class="inline-flex items-center justify-center px-space-lg py-space-sm rounded-lg bg-gradient-to-r from-secondary-container to-secondary text-on-secondary font-title-md text-title-md shadow-[0_4px_14px_rgba(2,102,255,0.28)] hover:opacity-95 active:scale-98 transition-all" data-path="login" href="{{ route('login') }}">Iniciar sesión</a>
        </div>
    </div>
</header>
