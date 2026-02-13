<x-layouts.public>

    {{-- El carrito flotante ahora está en el layout public.blade.php --}}

    <section class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header del catálogo -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-store text-pink-600 mr-3"></i>
                        Catálogo de Productos
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Encuentra el regalo perfecto</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                        <i class="fas fa-box text-pink-500 mr-2"></i>
                        <span id="totalProducts" class="font-semibold">{{ $products->total() }}</span> productos
                    </span>
                </div>
            </div>

            <!-- Búsqueda mejorada -->
            <div class="mb-6">
                <div class="relative">
                    <i
                        class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" id="searchInput"
                        placeholder="Buscar productos por nombre, marca o categoría..."
                        class="w-full pl-14 pr-12 py-4 text-base bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-pink-500 focus:border-transparent shadow-sm transition-all placeholder:text-gray-400">
                    <button type="button"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden"
                        id="clearSearch">
                        <i class="fas fa-times-circle text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Filtros mejorados -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-6">
                <!-- Categorías -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center">
                            <i class="fas fa-filter mr-2 text-pink-600"></i>
                            Categorías
                        </h3>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full" id="resultCount">
                            {{ $products->count() }} resultados
                        </span>
                    </div>

                    <div class="relative group">
                        <button type="button" id="scrollLeft"
                            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-pink-50 text-pink-600 w-8 h-8 rounded-full shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all -ml-2">
                            <i class="fas fa-chevron-left text-sm"></i>
                        </button>

                        <div id="categoriesContainer"
                            class="flex gap-2 overflow-x-auto pb-2 scroll-smooth hide-scrollbar px-1">
                            <button type="button" data-category="all" class="category-btn active flex-shrink-0">
                                <i class="fas fa-th-large mr-1.5"></i>
                                Todas
                                <span class="count">{{ $products->total() }}</span>
                            </button>

                            @foreach ($categories as $category)
                            <button type="button" data-category="{{ $category->id }}"
                                class="category-btn flex-shrink-0">
                                <i class="fas fa-tag mr-1.5"></i>
                                {{ $category->name }}
                                <span class="count">{{ $category->products->count() }}</span>
                            </button>
                            @endforeach
                        </div>

                        <button type="button" id="scrollRight"
                            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-pink-50 text-pink-600 w-8 h-8 rounded-full shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all -mr-2">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Ordenar -->
                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <label class="text-sm font-medium text-gray-600 flex items-center flex-shrink-0">
                        <i class="fas fa-sort-amount-down mr-2 text-pink-500"></i>
                        Ordenar:
                    </label>
                    <select id="sortSelect"
                        class="flex-1 px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm font-medium bg-white cursor-pointer">
                        <option value="newest">Más recientes</option>
                        <option value="name-asc">Nombre (A-Z)</option>
                        <option value="name-desc">Nombre (Z-A)</option>
                        <option value="price-asc">Precio: Menor primero</option>
                        <option value="price-desc">Precio: Mayor primero</option>
                        <option value="stock-desc">Mayor stock</option>
                    </select>
                </div>
            </div>

            <!-- Grid de productos -->
            @if ($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3 sm:gap-4 mb-8"
                id="productsGrid">
                @foreach ($products as $product)
                <div class="product-card group bg-white rounded-xl border border-gray-100 hover:border-pink-300 transition-all duration-300 overflow-hidden hover:shadow-lg flex flex-col h-full {{ $product->stock == 0 ? 'opacity-70' : '' }}"
                    data-name="{{ strtolower($product->name) }}"
                    data-category="{{ $product->category_id ?? '' }}" data-price="{{ $product->precio_venta }}"
                    data-stock="{{ $product->stock }}">

                    <!-- Imagen con carrusel -->
                    <!-- Imagen con carrusel automático -->
                    <div class="relative aspect-square bg-gray-50 overflow-hidden group/img"
                        x-data="{
                                    current: 0,
                                    total: {{ $product->images->count() ?: 1 }},
                                    interval: null,
                                    start() {
                                        if (this.total > 1) {
                                            this.interval = setInterval(() => {
                                                this.current = (this.current + 1) % this.total;
                                            }, 1200);
                                        }
                                    },
                                    stop() {
                                        clearInterval(this.interval);
                                        this.current = 0;
                                    }
                                }" @mouseenter="start()" @mouseleave="stop()">

                        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
                            @if ($product->images->count() > 1)
                            @foreach ($product->images as $index => $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->name }}" loading="lazy" decoding="async"
                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 img-optimized"
                                :class="current === {{ $index }} ? 'opacity-100' : 'opacity-0'">
                            @endforeach
                            @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}" loading="lazy" decoding="async"
                                class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500 img-optimized">
                            @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                <i class="fas fa-box text-gray-300 text-4xl"></i>
                            </div>
                            @endif
                        </a>

                        {{-- Indicador de fotos (puntos) --}}
                        @if ($product->images->count() > 1)
                        <div
                            class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 opacity-0 group-hover/img:opacity-100 transition-opacity z-10">
                            @foreach ($product->images as $index => $image)
                            <span class="w-1.5 h-1.5 rounded-full transition-all duration-300"
                                :class="current === {{ $index }} ? 'bg-pink-600 w-3' : 'bg-white/80'"></span>
                            @endforeach
                        </div>
                        {{-- Contador de fotos --}}
                        <div
                            class="absolute top-2 right-2 bg-black/50 text-white text-[10px] px-1.5 py-0.5 rounded-full opacity-0 group-hover/img:opacity-100 transition-opacity">
                            <i class="fas fa-images mr-1"></i>{{ $product->images->count() }}
                        </div>
                        @endif
                        {{-- Badge de variantes --}}
                        @if ($product->variants->count() > 0)
                        @php $variantTypes = $product->variants->pluck('type')->unique(); @endphp
                        <div class="absolute bottom-2 left-2 flex gap-1 z-10">
                            @foreach ($variantTypes as $type)
                            <span
                                class="bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-medium px-1.5 py-0.5 rounded shadow-sm">
                                {{ $product->variants->where('type', $type)->count() }}
                                <i
                                    class="fas fa-{{ $type == 'Talla' ? 'ruler' : ($type == 'Color' ? 'palette' : 'layer-group') }} ml-0.5"></i>
                            </span>
                            @endforeach
                        </div>
                        @endif

                        {{-- Badges de estado --}}
                        @if ($product->stock == 0)
                        <div
                            class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-[2px]">
                            <span
                                class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                <i class="fas fa-times-circle mr-1"></i>Agotado
                            </span>
                        </div>
                        @else
                        @if ($product->created_at->diffInDays() < 7)
                            <span
                            class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow z-10">
                            NUEVO
                            </span>
                            @endif
                            @if ($product->stock <= 10 && $product->stock > 0)
                                <span class="absolute top-2 {{ $product->images->count() > 1 ? 'right-14' : 'right-2' }} bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow animate-pulse z-10">
                                    ¡Últimos!
                                </span>
                                @endif

                                @if($product->has_discount)
                                <span class="absolute top-8 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow z-10">
                                    OFERTA -{{ $product->discount_percentage }}% MENOS
                                </span>
                                @endif
                                @endif
                    </div>

                    <!-- Info del producto -->
                    <div class="p-3 flex flex-col flex-1">
                        <div class="flex items-center gap-1.5 mb-1.5 flex-wrap">
                            @if ($product->category)
                            <span
                                class="text-[10px] font-semibold text-pink-600 bg-pink-50 px-2 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                            @endif
                            @if ($product->variants->count() > 0)
                            <span class="text-[10px] text-gray-500">
                                • Varias opciones
                            </span>
                            @endif
                        </div>

                        <h3
                            class="font-semibold text-sm text-gray-900 mb-2 line-clamp-2 leading-tight h-10 group-hover:text-pink-600 transition-colors">
                            {{ $product->name }}
                        </h3>

                        <!-- Precio y disponibilidad -->
                        <!-- Precio y disponibilidad (Refactorizado) -->
                        <div class="mb-3">
                            <div class="flex flex-col">
                                @if($product->has_discount)
                                <!-- Precio Oferta + Original -->
                                <div class="flex items-baseline gap-2 mb-1">
                                    <span class="text-lg font-bold text-pink-600">
                                        Q{{ number_format($product->discount_price, 2) }}
                                    </span>
                                    <span class="text-xs text-gray-400 line-through">
                                        Q{{ number_format($product->precio_venta, 2) }}
                                    </span>
                                </div>
                                <!-- Badge Descuento + Disponibilidad -->
                                <div class="flex items-center justify-between">
                                    @if ($product->stock > 0)
                                    <span class="text-[10px] font-medium text-green-600 flex items-center ml-auto">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        @if ($product->stock <= 10)
                                            {{ $product->stock }} disp.
                                            @else
                                            Disponible
                                            @endif
                                            </span>
                                            @endif
                                </div>
                                @else
                                <!-- Precio Normal -->
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-pink-600">
                                        Q{{ number_format($product->precio_venta, 2) }}
                                    </span>
                                    @if ($product->stock > 0)
                                    <span class="text-[10px] font-medium text-green-600 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        @if ($product->stock <= 10)
                                            {{ $product->stock }} disp.
                                            @else
                                            Disponible
                                            @endif
                                            </span>
                                            @endif
                                </div>
                                @endif
                            </div>
                        </div>


                        <!-- Botones de acción -->
                        <div class="mt-auto">
                            @if ($product->stock > 0)
                            @auth
                            @if (auth()->user()->email !== 'admin@admin.com')
                            <div class="flex gap-2">
                                @if ($product->variants->count() > 0)
                                {{-- Tiene variantes - ir a ver opciones --}}
                                <a href="{{ route('shop.product', $product->slug) }}"
                                    class="flex-1 flex items-center justify-center py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-all text-sm font-medium">
                                    <i class="fas fa-eye mr-1.5"></i>
                                    <span class="hidden sm:inline">Ver opciones</span>
                                    <span class="sm:hidden">Ver</span>
                                </a>
                                @else
                                {{-- Sin variantes - agregar directo --}}
                                @php
                                $finalPrice = $product->has_discount ? $product->discount_price : null;
                                @endphp
                                <button onclick="addToCart({{ $product->id }}, 1, {}, @json($finalPrice))"
                                    class="flex-1 flex items-center justify-center py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-all text-sm font-medium group/btn">
                                    <i
                                        class="fas fa-cart-plus mr-1.5 group-hover/btn:scale-110 transition-transform"></i>
                                    <span class="hidden sm:inline">Agregar</span>
                                </button>
                                @endif
                                <a href="https://wa.me/50249075678?text=Hola,%20me%20interesa%20el%20producto:%20{{ urlencode($product->name) }}%20-%20Q{{ number_format($product->has_discount ? $product->discount_price : $product->precio_venta, 2) }}"
                                    target="_blank"
                                    class="flex items-center justify-center w-10 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </a>
                            </div>
                            @else
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="block w-full py-2.5 text-center bg-gray-100 hover:bg-pink-600 hover:text-white text-gray-700 rounded-lg font-medium text-sm transition-all">
                                <i class="fas fa-edit mr-1.5"></i>Editar producto
                            </a>
                            @endif
                            @else
                            <!-- Invitados -->
                            <div class="flex gap-2">
                                @if ($product->variants->count() > 0)
                                <a href="{{ route('shop.product', $product->slug) }}"
                                    class="flex-1 flex items-center justify-center py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-all text-sm font-medium">
                                    <i class="fas fa-eye mr-1.5"></i>
                                    <span class="hidden sm:inline">Ver opciones</span>
                                    <span class="sm:hidden">Ver</span>
                                </a>
                                @else
                                @php
                                $finalPrice = $product->has_discount ? $product->discount_price : null;
                                @endphp
                                <button onclick="addToCart({{ $product->id }}, 1, {}, @json($finalPrice))"
                                    class="flex-1 flex items-center justify-center py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-all text-sm font-medium group/btn">
                                    <i
                                        class="fas fa-cart-plus mr-1.5 group-hover/btn:scale-110 transition-transform"></i>
                                    <span class="hidden sm:inline">Agregar</span>
                                </button>
                                @endif
                                <a href="https://wa.me/50249075678?text=Hola,%20me%20interesa%20el%20producto:%20{{ urlencode($product->name) }}%20-%20Q{{ number_format($product->has_discount ? $product->discount_price : $product->precio_venta, 2) }}"
                                    target="_blank"
                                    class="flex items-center justify-center w-10 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </a>
                            </div>
                            @endauth
                            @else
                            <!-- Sin stock -->
                            <a href="https://wa.me/50249075678?text=Hola,%20el%20producto%20{{ urlencode($product->name) }}%20está%20agotado.%20¿Cuándo%20estará%20disponible?"
                                target="_blank"
                                class="flex items-center justify-center w-full py-2.5 bg-gray-200 hover:bg-green-500 hover:text-white text-gray-600 rounded-lg transition-all text-sm font-medium">
                                <i class="fab fa-whatsapp mr-1.5"></i>Consultar disponibilidad
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación mejorada -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                {{ $products->links() }}
            </div>
            @else
            <!-- Estado vacío -->
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No hay productos disponibles</h3>
                <p class="text-gray-500 mb-6">Pronto agregaremos más productos al catálogo</p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-6 py-3 bg-pink-600 text-white rounded-xl font-medium hover:bg-pink-700 transition-all">
                    <i class="fas fa-home mr-2"></i>Volver al inicio
                </a>
            </div>
            @endif
        </div>
    </section>

    <style>
        /* Ocultar scrollbar */
        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Botones de categoría */
        .category-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            background: #f9fafb;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            white-space: nowrap;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .category-btn:hover {
            background: #fdf2f8;
            border-color: #fbcfe8;
            transform: translateY(-1px);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #db2777, #e11d48);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(219, 39, 119, 0.25);
        }

        .category-btn .count {
            margin-left: 6px;
            padding: 2px 6px;
            background: rgba(0, 0, 0, 0.08);
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
        }

        .category-btn.active .count {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Optimización de imágenes */
        .img-optimized {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        /* Cards con mejor sombra */
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        /* Animación de carga para imágenes */
        .product-card img:not([x-show]):not([\:class]) {
            opacity: 0;
            animation: fadeIn 0.01s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>

    @push('scripts')
    <script>
        // Búsqueda con debounce
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const value = this.value.trim();

                // Mostrar/ocultar botón de limpiar
                if (clearSearch) {
                    clearSearch.classList.toggle('hidden', value.length === 0);
                }

                searchTimeout = setTimeout(() => {
                    filterProducts();
                }, 300);
            });
        }

        if (clearSearch) {
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                this.classList.add('hidden');
                filterProducts();
                searchInput.focus();
            });
        }

        // Función de filtrado
        function filterProducts() {
            const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            products.forEach(product => {
                const name = product.dataset.name || '';
                const matches = name.includes(searchValue);
                product.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Actualizar contador
            const resultCount = document.getElementById('resultCount');
            if (resultCount) {
                resultCount.textContent = visibleCount + ' resultados';
            }
        }

        // Scroll de categorías
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');
        const categoriesContainer = document.getElementById('categoriesContainer');

        if (scrollLeftBtn && categoriesContainer) {
            scrollLeftBtn.addEventListener('click', () => {
                categoriesContainer.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });
        }

        if (scrollRightBtn && categoriesContainer) {
            scrollRightBtn.addEventListener('click', () => {
                categoriesContainer.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        }

        // Filtro por categoría
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Actualizar estado activo
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;
                const products = document.querySelectorAll('.product-card');
                let visibleCount = 0;

                products.forEach(product => {
                    if (category === 'all' || product.dataset.category === category) {
                        product.style.display = '';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
                });

                // Actualizar contador
                const resultCount = document.getElementById('resultCount');
                if (resultCount) {
                    resultCount.textContent = visibleCount + ' resultados';
                }
            });
        });

        // Ordenamiento
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const grid = document.getElementById('productsGrid');
                const products = Array.from(grid.querySelectorAll('.product-card'));

                products.sort((a, b) => {
                    switch (this.value) {
                        case 'name-asc':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'name-desc':
                            return b.dataset.name.localeCompare(a.dataset.name);
                        case 'price-asc':
                            return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                        case 'price-desc':
                            return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                        case 'stock-desc':
                            return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
                        default:
                            return 0;
                    }
                });

                products.forEach(product => grid.appendChild(product));
            });
        }


        // Función para agregar al carrito
        function addToCart(productId, quantity = 1, variants = {}, finalPrice = null) {
            Livewire.dispatch('add-to-cart', {
                productId: productId,
                quantity: quantity,
                variants: variants,
                finalPrice: finalPrice
            });
        }
    </script>
    @endpush

</x-layouts.public>