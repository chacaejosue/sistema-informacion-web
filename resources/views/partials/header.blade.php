<!-- Encabezado principal de Finora -->
<header class="fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="h-20 max-w-7xl mx-auto px-space-md lg:px-margin flex items-center justify-between">
        <!-- Logotipo e identidad de marca -->
        <div class="flex items-center gap-space-lg">
            <a class="flex items-center gap-space-sm group" data-path="inicio" href="{{ route('landing') }}" id="nav-inicio">
                <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform"/>
                <div class="flex flex-col leading-none">
                    {{-- 1.6: "Catálogo Online" ahora debajo de "Finora" para alinear correctamente --}}
                    <span class="font-headline-md text-headline-md text-primary-container tracking-tight">Finora</span>
                    <span class="text-[10px] font-medium text-on-surface-variant tracking-wide mt-0.5">Catálogo Online</span>
                </div>
            </a>

            <!-- Navegación principal del sitio -->
            <nav class="hidden lg:flex items-center gap-space-lg pl-space-md">
                {{-- 1.4: Mismo tamaño (font-title-md text-title-md) en activo e inactivo --}}
                <a id="nav-inicio-link" class="font-title-md text-title-md transition-colors {{ request()->routeIs('landing') ? 'text-secondary' : 'text-on-surface-variant hover:text-on-surface' }}" data-path="inicio" href="{{ route('landing') }}">Inicio</a>
                {{-- 1.12: Cambiado de "Catálogo" a "Destacados" | 1.5: estado hover igual a los otros --}}
                <a id="nav-destacados" class="font-title-md text-title-md transition-colors text-on-surface-variant hover:text-secondary" data-path="destacados" href="{{ route('landing') }}#catalogo-destacados">Destacados</a>
                <a class="font-title-md text-title-md transition-colors {{ request()->routeIs('categorias') ? 'text-secondary' : 'text-on-surface-variant hover:text-on-surface' }}" data-path="categorias" href="{{ route('categorias') }}">Categorías</a>
            </nav>
        </div>

        <!-- Botón de acceso a inicio de sesión -->
        <div class="flex items-center gap-space-md">
            <a class="inline-flex items-center justify-center px-space-lg py-space-sm rounded-lg bg-gradient-to-r from-secondary-container to-secondary text-on-secondary font-title-md text-title-md shadow-[0_4px_14px_rgba(2,102,255,0.28)] hover:opacity-95 active:scale-98 transition-all" data-path="login" href="{{ route('login') }}">Iniciar sesión</a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1.7: "Inicio" hace scroll suave al top si ya estamos en la landing, sin recargar
        const navInicio = document.getElementById('nav-inicio');
        const navInicioLink = document.getElementById('nav-inicio-link');
        [navInicio, navInicioLink].forEach(el => {
            if (!el) return;
            el.addEventListener('click', (e) => {
                if (window.location.pathname === '/' || window.location.pathname === '') {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });

        // 1.5: Iluminar "Destacados" cuando el hash es #catalogo-destacados
        const navDestacados = document.getElementById('nav-destacados');
        function updateDestacadosState() {
            if (!navDestacados) return;
            if (window.location.hash === '#catalogo-destacados') {
                navDestacados.classList.add('text-secondary');
                navDestacados.classList.remove('text-on-surface-variant', 'hover:text-secondary');
            } else {
                navDestacados.classList.remove('text-secondary');
                navDestacados.classList.add('text-on-surface-variant', 'hover:text-secondary');
            }
        }
        updateDestacadosState();
        window.addEventListener('hashchange', updateDestacadosState);
    });
</script>
