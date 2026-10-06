document.addEventListener('DOMContentLoaded', () => {
    const productItems = document.querySelectorAll('.product-item');
    const filterChips = document.querySelectorAll('.filter-chip');
    const searchInput = document.getElementById('catalog-search');
    const emptyState = document.getElementById('landingEmptyCatalog');
    const emptyMessage = document.getElementById('landingEmptyMessage');

    if (productItems.length === 0 && filterChips.length === 0 && !searchInput) {
        return;
    }

    let currentCategory = 'all';
    let searchQuery = '';

    function updateVisibility() {
        productItems.forEach(item => {
            const catMatch = currentCategory === 'all' || item.getAttribute('data-cat') === currentCategory;
            const textMatch = !searchQuery || item.innerText.toLowerCase().includes(searchQuery);

            if (catMatch && textMatch) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });

        const visible = [...productItems].filter(item => item.style.display !== 'none').length;
        emptyState?.classList.toggle('hidden', visible > 0);
        if (emptyMessage && visible === 0) {
            emptyMessage.textContent = currentCategory !== 'all'
                ? 'No encontramos productos con esa búsqueda dentro de la categoría seleccionada. Prueba otra categoría o revisa el nombre.'
                : 'Prueba con otro nombre o selecciona una categoría diferente.';
        }
    }

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => {
                c.classList.remove('bg-secondary', 'text-on-secondary', 'shadow-sm', 'active');
                c.classList.add('bg-surface-container-low', 'text-primary-container');
            });
            chip.classList.add('bg-secondary', 'text-on-secondary', 'shadow-sm', 'active');
            chip.classList.remove('bg-surface-container-low', 'text-primary-container');

            currentCategory = chip.getAttribute('data-cat') || 'all';
            updateVisibility();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase().trim();
            updateVisibility();
        });

        // Al presionar Enter en el buscador, hacer scroll a la sección de catálogo
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('catalogo-destacados')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    const searchBtn = document.getElementById('search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            document.getElementById('catalogo-destacados')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }
});
