

document.addEventListener('DOMContentLoaded', function() {

    
    const searchInput = document.getElementById('searchInput');
    const categoryBtns = document.querySelectorAll('.category-btn');
    const sortSelect = document.getElementById('sortSelect');
    const productsGrid = document.getElementById('productsGrid');
    const resultCount = document.getElementById('resultCount');
    const scrollLeft = document.getElementById('scrollLeft');
    const scrollRight = document.getElementById('scrollRight');
    const categoriesContainer = document.getElementById('categoriesContainer');

    if (!productsGrid) {

        return;
    }

    const allCards = Array.from(document.querySelectorAll('.product-card'));

    
    let selectedCategory = 'all';

    // Scroll arrows
    if (scrollLeft && categoriesContainer) {
        scrollLeft.addEventListener('click', function() {
            categoriesContainer.scrollBy({ left: -200, behavior: 'smooth' });
        });
    }

    if (scrollRight && categoriesContainer) {
        scrollRight.addEventListener('click', function() {
            categoriesContainer.scrollBy({ left: 200, behavior: 'smooth' });
        });
    }

    // Category filter
    categoryBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {

            
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            selectedCategory = this.dataset.category;
            filterAndSort();
        });
    });

    // Search
    if (searchInput) {
        searchInput.addEventListener('input', filterAndSort);
    }

    // Sort
    if (sortSelect) {
        sortSelect.addEventListener('change', filterAndSort);
    }

    function filterAndSort() {

        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const sortBy = sortSelect ? sortSelect.value : 'newest';

        let visibleCards = allCards.filter(function(card) {
            const name = card.dataset.name || '';
            const category = card.dataset.category || '';
            
            const matchesSearch = !searchTerm || name.includes(searchTerm);
            const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
            
            return matchesSearch && matchesCategory;
        });



        // Sort
        visibleCards.sort(function(a, b) {
            const aName = a.dataset.name || '';
            const bName = b.dataset.name || '';
            const aPrice = parseFloat(a.dataset.price) || 0;
            const bPrice = parseFloat(a.dataset.price) || 0;
            const aStock = parseInt(a.dataset.stock) || 0;
            const bStock = parseInt(b.dataset.stock) || 0;

            switch(sortBy) {
                case 'name-asc': return aName.localeCompare(bName);
                case 'name-desc': return bName.localeCompare(aName);
                case 'price-asc': return aPrice - bPrice;
                case 'price-desc': return bPrice - aPrice;
                case 'stock-desc': return bStock - aStock;
                default: return 0;
            }
        });

        // Hide all
        allCards.forEach(card => card.style.display = 'none');

        // Clear grid
        productsGrid.innerHTML = '';
        
        // Show filtered
        if (visibleCards.length > 0) {
            visibleCards.forEach(function(card) {
                card.style.display = 'block';
                productsGrid.appendChild(card);
            });
        } else {
            productsGrid.innerHTML = `
                <div class="col-span-full text-center py-16 bg-white rounded-2xl">
                    <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron productos</h3>
                    <p class="text-gray-600">Intenta con otros filtros o términos de búsqueda.</p>
                </div>
            `;
        }

        // Update counter
        if (resultCount) {
            resultCount.textContent = visibleCards.length + ' resultado' + (visibleCards.length !== 1 ? 's' : '');
        }
    }
});