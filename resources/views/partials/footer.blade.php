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
                <ul class="flex flex-col gap-space-xs font-body-md text-body-md text-on-surface-variant">
                    <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="{{ route('categorias') }}">Perfumería</a></li>
                    <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="{{ route('categorias') }}">Cuidado Facial</a></li>
                    <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="{{ route('categorias') }}">Maquillaje</a></li>
                    <li><a class="hover:text-secondary transition-colors" data-path="categorias" href="{{ route('categorias') }}">Cuidado Corporal</a></li>
                </ul>
            </div>

            <!-- Columna 3: Asistencia directa y contacto por WhatsApp -->
            <div class="lg:col-span-4 flex flex-col gap-space-sm">
                <h3 class="font-title-md text-title-md text-on-surface">Asistencia Directa</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">¿Tienes dudas sobre algún producto? Chatea directamente con tu consultor.</p>
                <a class="inline-flex items-center justify-center gap-space-xs px-space-md py-space-sm rounded-lg bg-surface-container-lowest text-on-surface hover:bg-surface-container hover:text-on-surface font-title-md text-title-md shadow-[0_2px_8px_-2px_rgba(11,25,44,0.04)] transition-all" data-path="contacto-consultor" href="https://wa.me/?text=Hola%20deseo%20consultar%20el%20cat%C3%A1logo%20Finora" target="_blank" rel="noopener noreferrer">
                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                    WhatsApp Consultor
                </a>
            </div>
        </div>

        <!-- Barra inferior: Derechos reservados y enlaces legales -->
        <div class="mt-space-2xl pt-space-md flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container-highest/60">
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center sm:text-left">Finora © {{ date('Y') }} - Catálogo digital para consultor independiente Natura. Todos los derechos reservados.</p>
            <div class="flex items-center gap-space-lg font-body-sm text-body-sm text-on-surface-variant">
                <a class="hover:text-on-surface transition-colors" data-path="aviso-privacidad" href="#">Aviso de privacidad</a>
                <a class="hover:text-on-surface transition-colors" data-path="terminos-servicio" href="#">Términos de servicio</a>
            </div>
        </div>
    </div>
</footer>
