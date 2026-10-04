import './landing.js';

const themeStorageKey = 'finora-theme';
const storedTheme = window.localStorage.getItem(themeStorageKey);
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

function applyTheme(theme) {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.style.colorScheme = theme;
}

applyTheme(storedTheme === 'dark' || (!storedTheme && prefersDark) ? 'dark' : 'light');
document.documentElement.classList.add('theme-ready');

document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.createElement('button');
    const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';

    themeToggle.type = 'button';
    themeToggle.className = 'finora-theme-toggle';
    themeToggle.setAttribute('aria-label', currentTheme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
    themeToggle.setAttribute('title', themeToggle.getAttribute('aria-label'));
    themeToggle.innerHTML = `<span class="material-symbols-outlined" aria-hidden="true">${currentTheme === 'dark' ? 'light_mode' : 'dark_mode'}</span>`;

    themeToggle.addEventListener('click', () => {
        const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(nextTheme);
        window.localStorage.setItem(themeStorageKey, nextTheme);
        const label = nextTheme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro';
        themeToggle.setAttribute('aria-label', label);
        themeToggle.setAttribute('title', label);
        themeToggle.querySelector('span').textContent = nextTheme === 'dark' ? 'light_mode' : 'dark_mode';
    });

    let floatingButtons = document.getElementById('floating-buttons');

    if (!floatingButtons && window.location.pathname.startsWith('/panel')) {
        floatingButtons = document.createElement('div');
        floatingButtons.id = 'floating-buttons';
        floatingButtons.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-3 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none';
        floatingButtons.innerHTML = `
            <button id="backToTopPanelBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})"
                class="w-12 h-12 flex items-center justify-center rounded-full bg-surface-container-lowest shadow-lg border border-surface-container-high/60 text-secondary hover:bg-secondary hover:text-on-secondary transition-all hover:shadow-xl hover:scale-105 active:scale-95 cursor-pointer"
                aria-label="Volver arriba" title="Volver arriba">
                <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
            </button>
        `;
        document.body.appendChild(floatingButtons);
    }

    if (floatingButtons) {
        floatingButtons.appendChild(themeToggle);

        if (window.location.pathname.startsWith('/panel') && !document.getElementById('backToTopBtn')) {
            const updateFloatingButtons = () => {
                const isVisible = window.scrollY > 220;
                floatingButtons.classList.toggle('opacity-0', !isVisible);
                floatingButtons.classList.toggle('translate-y-4', !isVisible);
                floatingButtons.classList.toggle('pointer-events-none', !isVisible);
                floatingButtons.classList.toggle('opacity-100', isVisible);
                floatingButtons.classList.toggle('translate-y-0', isVisible);
                floatingButtons.classList.toggle('pointer-events-auto', isVisible);
            };

            window.addEventListener('scroll', updateFloatingButtons, { passive: true });
            updateFloatingButtons();
        }
    } else {
        document.body.appendChild(themeToggle);
    }

    document.querySelectorAll('[id="openPanelDrawerBtn"]').forEach(button => {
        button.setAttribute('aria-label', 'Abrir navegación de módulos');
        button.setAttribute('aria-controls', 'panelDrawer');
        button.setAttribute('aria-expanded', 'false');
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            if (form.dataset.preventSubmitFeedback === 'true') return;

            form.classList.add('finora-form-submitting');
            form.setAttribute('aria-busy', 'true');

            form.querySelectorAll('button[type="submit"]').forEach(button => {
                button.disabled = true;
                button.setAttribute('data-original-label', button.getAttribute('aria-label') || '');
                button.setAttribute('aria-label', 'Procesando solicitud');
            });
        });
    });

    // Alternar visibilidad de contraseña en la vista de inicio de sesión
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            toggleBtn.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    }

    // Interacción y filtro reactivo para la vista de categorías
    const search = document.getElementById('catalogSearch');
    const filters = document.querySelectorAll('.category-filter');
    const products = document.querySelectorAll('.catalog-product');
    const count = document.getElementById('resultsCount');
    const empty = document.getElementById('emptyCatalog');

    if (filters.length > 0 && products.length > 0) {
        let activeCategory = 'all';

        function refreshCatalog() {
            const term = search ? search.value.trim().toLocaleLowerCase('es') : '';
            let visible = 0;
            products.forEach(product => {
                const matchesCategory = activeCategory === 'all' || product.dataset.productCategory === activeCategory;
                const matchesSearch = !term || product.textContent.toLocaleLowerCase('es').includes(term);
                const show = matchesCategory && matchesSearch;
                product.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (count) {
                count.textContent = `${visible} producto${visible === 1 ? '' : 's'} disponible${visible === 1 ? '' : 's'}`;
            }
            if (empty) {
                empty.style.display = visible ? 'none' : 'block';
            }
        }

        filters.forEach(button => {
            button.addEventListener('click', () => {
                activeCategory = button.dataset.category;
                filters.forEach(filter => {
                    const selected = filter === button;
                    filter.setAttribute('aria-pressed', String(selected));
                    filter.classList.toggle('bg-secondary', selected);
                    filter.classList.toggle('text-on-secondary', selected);
                    filter.classList.toggle('bg-surface-container-low', !selected);
                    filter.classList.toggle('text-on-surface', !selected);
                });
                refreshCatalog();
            });
        });

        if (search) {
            search.addEventListener('input', refreshCatalog);
        }
    }

    // Auto-dismiss y botón de cierre para mensajes flash de alerta
    const alerts = document.querySelectorAll('div[role="alert"]');
    alerts.forEach(alert => {
        // Evitar aplicar a la caja de error del login que se maneja via ajax
        if (alert.id === 'loginErrorBox' || alert.id === 'form-validation-alert') return;
        alert.classList.add('finora-toast', 'relative', 'overflow-hidden');
        alert.classList.add('finora-toast', 'relative', 'overflow-hidden');

        if (!alert.querySelector('.alert-close-btn')) {
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'alert-close-btn ml-auto p-1 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer shrink-0';
            closeBtn.innerHTML = '<span class="material-symbols-outlined text-sm">close</span>';
            closeBtn.setAttribute('aria-label', 'Cerrar notificación');
            closeBtn.addEventListener('click', () => {
                alert.classList.add('hide-toast');
                setTimeout(() => alert.remove(), 300);
            });
            alert.appendChild(closeBtn);
        }

        // Auto-dismiss suave tras 5 segundos
        setTimeout(() => {
            if (alert && alert.parentElement) {
                alert.classList.add('hide-toast');
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });

    // Vista previa interactiva al seleccionar una imagen de producto
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;

            let previewContainer = input.parentElement.querySelector('.image-file-preview');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.className = 'image-file-preview mt-3 flex items-center gap-3 p-2.5 bg-slate-50 border border-slate-200 rounded-xl animate-scale-up';
                input.parentElement.appendChild(previewContainer);
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" alt="Vista previa" class="w-14 h-14 object-cover rounded-lg border border-slate-300 shrink-0">
                    <div class="flex flex-col text-xs text-slate-600 truncate">
                        <span class="font-bold text-finora-navy truncate">${file.name}</span>
                        <span class="text-[10px] text-slate-400">${(file.size / 1024).toFixed(1)} KB</span>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        });
    });
});
