import './landing.js';

document.addEventListener('DOMContentLoaded', () => {
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
                count.textContent = `${visible} producto${visible === 1 ? '' : 's'} demostrativo${visible === 1 ? '' : 's'}`;
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
});
