<!-- Encabezado principal de Finora — Sitio público -->
<header class="public-header-bar fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="public-header-inner h-20 max-w-7xl mx-auto px-space-md lg:px-margin flex items-center justify-between">

        <!-- Logotipo e identidad de marca -->
        <div class="flex items-center gap-space-lg">
            <a class="flex items-center gap-space-sm group" href="{{ route('landing') }}" id="nav-inicio">
                <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora"
                    class="public-header-logo h-10 w-auto object-contain group-hover:scale-105 transition-transform"/>
                <div class="public-header-brand flex flex-col leading-none">
                    <span class="font-headline-md text-headline-md text-primary-container tracking-tight">Finora</span>
                    <span class="public-header-subtitle text-[10px] font-medium text-on-surface-variant tracking-wide mt-0.5">Catálogo Online</span>
                </div>
            </a>

            <!-- Navegación principal (desktop) -->
            <nav class="hidden lg:flex items-center gap-space-lg pl-space-md">
                <a id="nav-inicio-link"
                    class="font-title-md text-title-md transition-colors {{ request()->routeIs('landing') ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-secondary' }}"
                    href="{{ route('landing') }}">Inicio</a>
                <a id="nav-destacados"
                    class="font-title-md text-title-md transition-colors text-on-surface-variant hover:text-secondary"
                    href="{{ route('landing') }}#catalogo-destacados">Destacados</a>
                <a id="nav-categorias"
                    class="font-title-md text-title-md transition-colors {{ request()->routeIs('categorias') ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-secondary' }}"
                    href="{{ route('categorias') }}">Categorías</a>
            </nav>
        </div>

        <!-- Acciones del header -->
        <div class="flex items-center gap-space-sm">
            <a href="{{ route('carrito') }}" class="relative inline-flex items-center justify-center rounded-xl p-2.5 text-on-surface-variant hover:bg-surface-container hover:text-secondary" aria-label="Ver carrito" title="Ver carrito">
                <span class="material-symbols-outlined text-[22px]">shopping_cart</span>
                <span id="publicCartBadge" class="absolute -right-1 -top-1 hidden min-w-5 rounded-full bg-emerald-600 px-1 text-center text-[10px] font-bold leading-5 text-white">0</span>
             </a>
            <span class="theme-toggle-slot"></span>
            <!-- Botón iniciar sesión -->
            <a class="public-header-login inline-flex items-center justify-center px-3 py-2 sm:px-space-lg sm:py-space-sm rounded-xl bg-gradient-to-r from-secondary-container to-secondary text-on-secondary font-title-md text-xs sm:text-title-md whitespace-nowrap shadow-[0_4px_14px_rgba(2,102,255,0.28)] hover:shadow-[0_6px_20px_rgba(2,102,255,0.38)] hover:-translate-y-0.5 active:translate-y-0 transition-all cursor-pointer"
                href="{{ route('login') }}">
                <span class="material-symbols-outlined public-header-login-icon text-[18px] mr-1">login</span>
                <span class="public-header-login-label sm:hidden">Ingresar</span>
                <span class="hidden sm:inline">Iniciar sesión</span>
            </a>

            <!-- Hamburguesa (mobile) -->
            <button id="mobile-menu-toggle"
                class="lg:hidden p-2.5 rounded-xl text-on-surface-variant hover:text-on-surface hover:bg-surface-container active:scale-95 transition-all cursor-pointer"
                aria-label="Abrir menú" aria-controls="mobile-menu" aria-expanded="false">
                <span class="material-symbols-outlined text-[24px]" id="mobile-menu-icon">menu</span>
            </button>
        </div>
    </div>

    <!-- Menú móvil desplegable con animación -->
    <div id="mobile-menu"
        class="hidden lg:hidden border-t border-surface-container-high/40 bg-surface-container-lowest/98 backdrop-blur-xl px-space-md pb-5 shadow-xl transition-all"
        aria-label="Navegación móvil" aria-hidden="true">
        <nav class="flex flex-col gap-1.5 pt-3">
            <a id="mobile-nav-inicio" href="{{ route('landing') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-title-md text-title-md transition-colors {{ request()->routeIs('landing') ? 'bg-secondary/10 text-secondary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-secondary' }}">
                <span class="material-symbols-outlined text-[20px]">home</span>
                Inicio
            </a>
            <a id="mobile-nav-destacados" href="{{ route('landing') }}#catalogo-destacados"
                class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-xl font-title-md text-title-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">star</span>
                Destacados
            </a>
            <a id="mobile-nav-categorias" href="{{ route('categorias') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-title-md text-title-md transition-colors {{ request()->routeIs('categorias') ? 'bg-secondary/10 text-secondary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-secondary' }}">
                <span class="material-symbols-outlined text-[20px]">category</span>
                Categorías
            </a>
            <div class="border-t border-surface-container-high/40 mt-2 pt-3">
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-title-md text-title-md bg-secondary text-on-secondary shadow-md hover:bg-secondary-container transition-all">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciar sesión
                </a>
            </div>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.querySelector('.public-header-bar');
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileIcon = document.getElementById('mobile-menu-icon');

        // Scroll dinámico en header para efecto de elevación
        if (header) {
            const handleScroll = () => {
                if (window.scrollY > 20) {
                    header.classList.add('shadow-md', 'border-b', 'border-surface-container-high/50');
                } else {
                    header.classList.remove('shadow-md', 'border-b', 'border-surface-container-high/50');
                }
            };
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }

        const cartBadge = document.getElementById('publicCartBadge');
        if (cartBadge) {
            const cart = JSON.parse(window.localStorage.getItem('finora-carrito') || '[]');
            const count = cart.reduce((total, item) => total + Number(item.qty || 0), 0);
            cartBadge.textContent = count;
            cartBadge.classList.toggle('hidden', count === 0);
        }

        // Toggle del menú móvil
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isExpanded = mobileToggle.getAttribute('aria-expanded') === 'true';
                mobileToggle.setAttribute('aria-expanded', String(!isExpanded));
                mobileMenu.setAttribute('aria-hidden', String(isExpanded));
                mobileMenu.classList.toggle('hidden', isExpanded);
                if (mobileIcon) {
                    mobileIcon.textContent = isExpanded ? 'menu' : 'close';
                }
            });

            // Cerrar menú al hacer clic en enlaces internos o fuera
            document.querySelectorAll('.mobile-nav-link, #mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                    mobileMenu.setAttribute('aria-hidden', 'true');
                    if (mobileIcon) mobileIcon.textContent = 'menu';
                });
            });

            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                    mobileMenu.setAttribute('aria-hidden', 'true');
                    if (mobileIcon) mobileIcon.textContent = 'menu';
                }
            });
        }

        // Scroll suave al top en "Inicio" si ya estamos en la landing
        const navInicio = document.getElementById('nav-inicio');
        const navInicioLink = document.getElementById('nav-inicio-link');
        const mobileNavInicio = document.getElementById('mobile-nav-inicio');
        [navInicio, navInicioLink, mobileNavInicio].forEach(el => {
            if (!el) return;
            el.addEventListener('click', (e) => {
                if (window.location.pathname === '/' || window.location.pathname === '') {
                    e.preventDefault();
                    if (window.location.hash) {
                        window.history.replaceState(null, '', window.location.pathname + window.location.search);
                    }
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    updateDestacadosState();
                }
            });
        });

        // Iluminar "Destacados" cuando el hash es #catalogo-destacados
        const navDestacados = document.getElementById('nav-destacados');
        const mobileNavDestacados = document.getElementById('mobile-nav-destacados');

        function setActiveState(element, active, activeClasses, inactiveClasses) {
            if (!element) return;
            element.classList.toggle('text-secondary', active);
            element.classList.toggle('font-bold', active);
            activeClasses.forEach(className => element.classList.toggle(className, active));
            inactiveClasses.forEach(className => element.classList.toggle(className, !active));
        }

        function updateDestacadosState() {
            if (window.location.pathname !== '/' && window.location.pathname !== '') return;

            const isAtTop = window.scrollY <= 120;
            const isDestacadosActive = !isAtTop && window.location.hash === '#catalogo-destacados';
            setActiveState(navDestacados, isDestacadosActive, [], ['text-on-surface-variant', 'hover:text-secondary']);
            setActiveState(mobileNavDestacados, isDestacadosActive, ['bg-secondary/10'], ['text-on-surface-variant', 'hover:bg-surface-container', 'hover:text-on-surface']);
            setActiveState(navInicioLink, !isDestacadosActive, [], ['text-on-surface-variant', 'hover:text-on-surface']);
            setActiveState(mobileNavInicio, !isDestacadosActive, ['bg-secondary/10'], ['text-on-surface-variant', 'hover:bg-surface-container', 'hover:text-on-surface']);
        }
        updateDestacadosState();
        window.addEventListener('hashchange', updateDestacadosState);
        window.addEventListener('scroll', updateDestacadosState, { passive: true });
    });
</script>
