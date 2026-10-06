import './landing.js';

const themeStorageKey = 'finora-theme-v2';
const storedTheme = window.localStorage.getItem(themeStorageKey);

function applyTheme(theme) {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.style.colorScheme = theme;
}

applyTheme(storedTheme === 'dark' ? 'dark' : 'light');
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

    if (document.body.classList.contains('login-page')) {
        return;
    }

    const themeSlot = document.querySelector('.theme-toggle-slot');
    if (themeSlot) {
        themeSlot.appendChild(themeToggle);
        themeToggle.classList.add('order-last', 'inline-flex', 'items-center', 'justify-center', 'rounded-xl', 'p-2.5', 'text-on-surface-variant', 'hover:bg-surface-container', 'hover:text-secondary', 'transition-colors');
    } else if (window.location.pathname.startsWith('/panel')) {
        const panelHeaderActions = document.querySelector('header .flex.items-center.justify-between > div:last-child');
        if (panelHeaderActions) {
            panelHeaderActions.append(themeToggle);
            themeToggle.classList.add('order-last', 'inline-flex', 'items-center', 'justify-center', 'rounded-xl', 'p-2.5', 'text-on-surface-variant', 'hover:bg-surface-container', 'hover:text-secondary', 'transition-colors');
        } else if (floatingButtons) {
            floatingButtons.appendChild(themeToggle);
        }
    } else if (floatingButtons) {
        floatingButtons.appendChild(themeToggle);
    } else {
        document.body.appendChild(themeToggle);
    }

    if (floatingButtons && window.location.pathname.startsWith('/panel')) {
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

    if (document.getElementById('backToTopCatalog')) {
        themeToggle.classList.add('finora-theme-above-back-to-top');
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

    document.querySelectorAll('form label').forEach(label => {
        const field = label.querySelector('input, select, textarea');
        if (field && !field.required && !label.textContent.toLowerCase().includes('opcional')) {
            const optional = document.createElement('span');
            optional.className = 'ml-1 font-normal text-slate-400';
            optional.textContent = '(opcional)';
            label.appendChild(optional);
        }
    });

    if ((window.location.pathname.startsWith('/panel') || window.location.pathname.startsWith('/mi-cuenta')) && document.querySelector('form[action$="/logout"]')) {
        let lastActivity = Date.now();
        const markActivity = () => { lastActivity = Date.now(); };
        ['click', 'keydown', 'pointermove', 'scroll'].forEach(eventName => window.addEventListener(eventName, markActivity, {passive: true}));
        window.setInterval(() => {
            if (Date.now() - lastActivity >= 10 * 60 * 1000) {
                document.querySelector('form[action$="/logout"]')?.submit();
            }
        }, 30000);
    }

    window.finoraShowAdded = (button) => {
        button.classList.add('scale-95', 'ring-4', 'ring-emerald-200');
        const originalContent = button.innerHTML;
        button.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Añadido';
        button.setAttribute('aria-label', 'Producto añadido al carrito');
        window.setTimeout(() => {
            button.classList.remove('scale-95', 'ring-4', 'ring-emerald-200');
            button.innerHTML = originalContent;
        }, 900);
    };

    window.finoraAddProduct = (button) => {
        const productId = String(button.dataset.addProduct);
        const cart = JSON.parse(window.localStorage.getItem('finora-carrito') || '[]');
        const existing = cart.find(item => String(item.id) === productId);

        if (existing) existing.qty = Math.min(Number(existing.qty) + 1, 99);
        else cart.push({ id: productId, qty: 1 });

        window.localStorage.setItem('finora-carrito', JSON.stringify(cart));
        document.querySelectorAll('#publicCartBadge').forEach(badge => {
            badge.textContent = cart.reduce((total, item) => total + Number(item.qty || 0), 0);
            badge.classList.remove('hidden');
        });
        window.finoraShowAdded(button);
        const card = button.closest('.product-item, .catalog-product');
        if (card) {
            const flyOrb = document.createElement('span');
            flyOrb.className = 'finora-cart-orb fixed z-[100] pointer-events-none';
            const start = card.getBoundingClientRect();
            const cart = document.querySelector('[aria-label="Ver carrito"]');
            const end = cart?.getBoundingClientRect();
            if (end) {
                flyOrb.style.left = `${start.left + start.width / 2 - 12}px`;
                flyOrb.style.top = `${start.top + start.height / 2 - 12}px`;
                document.body.appendChild(flyOrb);
                requestAnimationFrame(() => {
                    flyOrb.style.left = `${end.left + end.width / 2 - 12}px`;
                    flyOrb.style.top = `${end.top + end.height / 2 - 12}px`;
                    flyOrb.classList.add('finora-cart-orb-flying');
                });
                setTimeout(() => flyOrb.remove(), 750);
            }
        }
    };

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-add-product]');
        if (!button || document.getElementById('publicOrderForm')) return;

        event.preventDefault();
        window.finoraAddProduct(button);
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
    const emptyMessage = document.getElementById('emptyCatalogMessage');
    const allCatalogProducts = window.finoraCatalogProducts || [];

    if (filters.length > 0) {
        let activeCategory = new URLSearchParams(window.location.search).get('categoria') || 'all';
        if (![...filters].some(filter => filter.dataset.category === activeCategory)) {
            activeCategory = 'all';
        }

        const setActiveFilter = () => {
            filters.forEach(filter => {
                const selected = filter.dataset.category === activeCategory;
                filter.setAttribute('aria-pressed', String(selected));
                filter.classList.toggle('bg-secondary', selected);
                filter.classList.toggle('text-on-secondary', selected);
                filter.classList.toggle('bg-surface-container-low', !selected);
                filter.classList.toggle('text-on-surface', !selected);
            });
        };

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
            if (emptyMessage && ! visible) {
                const otherCategory = allCatalogProducts.find(product => term && product.nombre.toLocaleLowerCase('es').includes(term) && product.categoria);
                emptyMessage.textContent = otherCategory
                    ? `Encontramos “${otherCategory.nombre}” en la categoría ${otherCategory.categoria}. Prueba seleccionando esa categoría.`
                    : 'No encontramos productos con esos filtros. Prueba con otro término o selecciona una categoría diferente.';
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

        setActiveFilter();
        refreshCatalog();
    }

    // Auto-dismiss y botón de cierre para mensajes flash de alerta
    const alerts = document.querySelectorAll('div[role="alert"]');
    alerts.forEach(alert => {
        // Evitar aplicar a la caja de error del login que se maneja via ajax
        if (alert.id === 'loginErrorBox' || alert.id === 'form-validation-alert') return;
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

    const optionalLabelObserver = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.nodeType !== Node.ELEMENT_NODE) return;
                const labels = [
                    ...(node.matches?.('label') ? [node] : []),
                    ...(node.querySelectorAll?.('label') || []),
                ];
                labels.forEach(label => {
                    const field = label.querySelector('input, select, textarea');
                    if (field && !field.required && !label.textContent.toLowerCase().includes('opcional')) {
                        const optional = document.createElement('span');
                        optional.className = 'ml-1 font-normal text-slate-400';
                        optional.textContent = '(opcional)';
                        label.appendChild(optional);
                    }
                });
            });
        });
    });
    optionalLabelObserver.observe(document.body, { childList: true, subtree: true });

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
