<!-- Pie de página principal de Finora -->
<footer class="relative z-10 w-full bg-surface-container-low mt-space-2xl">
    <div class="max-w-7xl mx-auto px-space-md lg:px-margin pt-space-2xl pb-space-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-space-xl">
            <!-- Columna 1: Logotipo y descripción corta de Finora -->
            <div class="lg:col-span-5 flex flex-col gap-space-md">
                <div class="flex items-center gap-space-sm">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-8 w-auto object-contain"/>
                    <span class="font-headline-sm text-headline-sm text-primary-container">Finora</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm">
                    Plataforma de gestión comercial y catálogo digital para consultor independiente Natura.
                </p>
            </div>

            <!-- Columna 2: Accesos directos a categorías del catálogo -->
            <div class="lg:col-span-3 flex flex-col gap-space-sm">
                <h3 class="font-title-md text-title-md text-on-surface">Categorías</h3>
                {{-- 1.3: Cada enlace lleva a la categoría específica, no a /categorias genérico --}}
                <ul class="flex flex-col gap-space-xs font-body-md text-body-md text-on-surface-variant">
                    <li><a class="hover:text-secondary transition-colors" href="{{ route('categorias', ['categoria' => 'perfumeria']) }}">Perfumería</a></li>
                    <li><a class="hover:text-secondary transition-colors" href="{{ route('categorias', ['categoria' => 'cuidado-facial']) }}">Cuidado Facial</a></li>
                    <li><a class="hover:text-secondary transition-colors" href="{{ route('categorias', ['categoria' => 'maquillaje']) }}">Maquillaje</a></li>
                    <li><a class="hover:text-secondary transition-colors" href="{{ route('categorias', ['categoria' => 'cuidado-corporal']) }}">Cuidado Corporal</a></li>
                </ul>
            </div>

            <!-- Columna 3: Asistencia directa y contacto por WhatsApp -->
            <div class="lg:col-span-4 flex flex-col gap-space-sm">
                <h3 class="font-title-md text-title-md text-on-surface">Asistencia Directa</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">¿Tienes dudas sobre algún producto o pedido? Chatea directamente con tu consultor de confianza.</p>
                {{-- Botón WhatsApp con icono SVG y efecto interactivo --}}
                <a class="inline-flex items-center justify-center gap-2 px-space-md py-2.5 rounded-xl bg-surface-container-lowest text-primary-container hover:bg-emerald-50 hover:text-emerald-800 hover:border-emerald-200 border border-surface-container-high/60 font-title-md text-title-md shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group" href="https://wa.me/59167673537?text=Hola%20deseo%20consultar%20el%20cat%C3%A1logo%20Finora" target="_blank" rel="noopener noreferrer">
                    <svg class="w-5 h-5 text-emerald-600 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.545 1.761.791 2.796.791 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.778-5.768-5.778zm0-2c4.28 0 7.768 3.488 7.768 7.778 0 4.281-3.487 7.766-7.768 7.766-1.328 0-2.597-.336-3.716-.941l-4.315 1.131 1.152-4.212c-.7-1.189-1.089-2.56-1.089-3.744 0-4.29 3.488-7.778 7.768-7.778z"/>
                    </svg>
                    <span>WhatsApp Consultor</span>
                    <span class="material-symbols-outlined text-[16px] text-on-surface-variant group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Barra inferior: Derechos reservados y enlaces legales -->
        <div class="mt-space-2xl pt-space-md flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container-highest/60">
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center sm:text-left">Finora © {{ date('Y') }} &bull; Catálogo digital para consultor independiente Natura. Todos los derechos reservados.</p>
            <div class="flex items-center gap-space-lg font-body-sm text-body-sm text-on-surface-variant">
                <span class="inline-flex items-center gap-1.5 text-xs text-secondary font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Atención activa
                </span>
            </div>
        </div>
    </div>
</footer>
