document.addEventListener('DOMContentLoaded', () => {
    const productItems = document.querySelectorAll('.product-item');
    const filterChips = document.querySelectorAll('.filter-chip');
    const searchInput = document.getElementById('catalog-search');

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
    }
});
