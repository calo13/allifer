<x-layouts.public>

    <!-- Header / Breadcrumbs -->
    <div class="bg-primary-900 py-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-300 hover:text-white">
                            <i class="fas fa-home mr-2"></i>Inicio
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-500 text-xs mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-secondary-500 md:ml-2">Catálogo</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-2">
                Agricultura, Mascotas y Avicultura
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">
                Todo para su producción y el cuidado de sus animales: semillas, fertilizantes, farmacia veterinaria y equipos especializados.
            </p>
        </div>
    </div>

    <section class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Barra de Herramientas (Search & Filter) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Búsqueda -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="searchInput"
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors"
                            placeholder="Buscar por nombre, marca o código...">
                        <button type="button" id="clearSearch" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                            <i class="fas fa-times text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                        </button>
                    </div>

                    <!-- Ordenar -->
                    <div class="w-full md:w-64">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-sort-amount-down text-gray-400"></i>
                            </div>
                            <select id="sortSelect"
                                class="block w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none cursor-pointer">
                                <option value="newest">Más recientes</option>
                                <option value="name-asc">Nombre (A-Z)</option>
                                <option value="name-desc">Nombre (Z-A)</option>
                                <option value="price-asc">Precio: Menor primero</option>
                                <option value="price-desc">Precio: Mayor primero</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorías (Tabs) -->
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 block">Filtrar por Categoría</span>
                    <div class="flex flex-wrap gap-2" id="categoriesContainer">
                        <button type="button" data-category="all"
                            class="category-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-transparent">
                            Todas
                        </button>
                        @foreach ($categories as $category)
                        <button type="button" data-category="{{ $category->id }}"
                            class="category-btn px-4 py-2 rounded-lg text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 hover:bg-white hover:border-primary-300 hover:text-primary-700 transition-all duration-200">
                            {{ $category->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grid de productos -->
            @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12" id="productsGrid">
                @foreach ($products as $product)
                <div class="product-card group bg-white rounded-xl border border-gray-100 hover:border-secondary-400 transition-all duration-300 overflow-hidden hover:shadow-xl flex flex-col h-full {{ $product->stock == 0 ? 'opacity-75 grayscale' : '' }}"
                    data-name="{{ strtolower($product->name) }}"
                    data-category="{{ $product->category_id ?? '' }}"
                    data-price="{{ $product->precio_venta }}"
                    data-stock="{{ $product->stock }}">

                    <!-- Imagen -->
                    <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                            @endif
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if ($product->stock == 0)
                            <span class="bg-gray-900 text-white text-xs font-bold px-2.5 py-1 rounded shadow-sm">
                                AGOTADO
                            </span>
                            @else
                            @if ($product->created_at->diffInDays() < 30)
                                <span class="bg-secondary-500 text-primary-900 text-xs font-bold px-2.5 py-1 rounded shadow-sm">
                                NUEVO
                                </span>
                                @endif
                                @if($product->has_discount)
                                <span class="bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded shadow-sm">
                                    -{{ $product->discount_percentage }}%
                                </span>
                                @endif
                                @endif
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-5 flex flex-col flex-1">
                        @if ($product->category)
                        <div class="mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        @endif

                        <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight group-hover:text-primary-700 transition-colors">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <!-- Precio -->
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex flex-col">
                                @if($product->has_discount)
                                <span class="text-xs text-gray-400 line-through">Q{{ number_format($product->precio_venta, 2) }}</span>
                                <span class="text-xl font-bold text-primary-700">Q{{ number_format($product->discount_price, 2) }}</span>
                                @else
                                <span class="text-xl font-bold text-primary-700">Q{{ number_format($product->precio_venta, 2) }}</span>
                                @endif
                            </div>

                            @if ($product->stock > 0)
                            <button onclick="addToCart({{ $product->id }}, 1, {}, {{ $product->has_discount ? $product->discount_price : 'null' }})"
                                class="w-10 h-10 rounded-full bg-primary-50 text-primary-700 hover:bg-primary-600 hover:text-white flex items-center justify-center transition-all shadow-sm hover:shadow-md"
                                title="Agregar al carrito">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>

            @else
            <!-- Estado vacío -->
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No se encontraron productos</h3>
                <p class="text-gray-500">Intenta ajustar los filtros o la búsqueda.</p>
            </div>
            @endif
        </div>
    </section>

    <style>
        .category-btn.active {
            background-color: #15803d;
            /* primary-700 */
            color: white;
            border-color: #15803d;
        }
    </style>

    @push('scripts')
    <script>
        // Logica de filtrado y búsqueda (mantenida pero ajustada a las nuevas clases)
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        const sortSelect = document.getElementById('sortSelect');
        const categoryBtns = document.querySelectorAll('.category-btn');
        const productsGrid = document.getElementById('productsGrid');

        // ... (Logica javascript existente pero simplificada/adaptada si es necesario) ...
        // Re-implementando la lógica básica para asegurar funcionamiento con nuevas clases

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const activeCategoryBtn = document.querySelector('.category-btn.active');
            const categoryId = activeCategoryBtn.dataset.category;
            const sortValue = sortSelect.value;

            const products = Array.from(productsGrid.querySelectorAll('.product-card'));

            products.forEach(product => {
                const name = product.dataset.name;
                const cat = product.dataset.category;

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = categoryId === 'all' || cat === categoryId;

                if (matchesSearch && matchesCategory) {
                    product.style.display = 'flex';
                } else {
                    product.style.display = 'none';
                }
            });

            // Sorting logic (visual only for current page)
            const visibleProducts = products.filter(p => p.style.display !== 'none');
            // ... sorting logic impl ...
        }

        searchInput.addEventListener('input', (e) => {
            clearSearch.classList.toggle('hidden', !e.target.value);
            filterProducts();
        });

        clearSearch.addEventListener('click', () => {
            searchInput.value = '';
            clearSearch.classList.add('hidden');
            filterProducts();
        });

        // Add to Cart Function
        function addToCart(productId, quantity = 1, variants = {}, price = null) {
            // Dispatch event to Livewire (assuming Livewire 3 syntax or custom event listener)
            // If using Livewire 3:
            Livewire.dispatch('add-to-cart', {
                productId: productId,
                quantity: quantity,
                variants: variants,
                finalPrice: price
            });

            // Optional: Show feedback toast
            // const toast = document.createElement('div');
            // toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce';
            // toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Agregado al carrito';
            // document.body.appendChild(toast);
            // setTimeout(() => toast.remove(), 2000);
        }

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterProducts();
            });
        });

        sortSelect.addEventListener('change', () => {
            const products = Array.from(productsGrid.querySelectorAll('.product-card'));
            products.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);
                const nameA = a.dataset.name;
                const nameB = b.dataset.name;

                switch (sortSelect.value) {
                    case 'price-asc':
                        return priceA - priceB;
                    case 'price-desc':
                        return priceB - priceA;
                    case 'name-asc':
                        return nameA.localeCompare(nameB);
                    case 'name-desc':
                        return nameB.localeCompare(nameA);
                    default:
                        return 0;
                }
            });
            products.forEach(p => productsGrid.appendChild(p));
        });
    </script>
    @endpush

</x-layouts.public>