<x-layouts.shop>
    <div class="container mx-auto px-4 py-8">

        <!-- Categorías -->
        @if($categories->count() > 0)
        <div class="mb-8">
            <div class="flex items-center space-x-2 overflow-x-auto pb-4">
                <a href="{{ route('shop.index') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Todos
                </a>
                @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ request('category') == $category->id ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }} ({{ $category->products_count }})
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Grid de productos -->
        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                <a href="{{ route('shop.product', $product->id) }}">
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-box text-gray-400 text-5xl"></i>
                    </div>
                    @endif
                </a>

                <div class="p-4">
                    <a href="{{ route('shop.product', $product->id) }}">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-indigo-600 line-clamp-2">
                            {{ $product->name }}
                        </h3>
                    </a>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xl font-bold text-indigo-600">
                            Q{{ number_format($product->precio_venta, 2) }}
                        </span>
                        <span class="text-sm text-gray-500">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>

                    <button wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        <i class="fas fa-cart-plus mr-2"></i>
                        Agregar al Carrito
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
            <p class="text-xl text-gray-600">No se encontraron productos</p>
        </div>
        @endif
    </div>

</x-layouts.shop>