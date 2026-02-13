<!-- Sección de Ofertas (Solo si hay productos con descuento) -->
@if($discountedProducts->count() > 0)
<section class="py-16 bg-gradient-to-b from-red-50 to-white relative overflow-hidden">
    <!-- Decoración fondo simplificada y elegante -->
    <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none overflow-hidden">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob opacity-70"></div>
        <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000 opacity-70"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header de la sección -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div class="text-center md:text-left w-full md:w-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold tracking-wider mb-3">
                    <i class="fas fa-fire"></i>
                    @if($activePromotions->count() > 0)
                    {{ Str::upper($activePromotions->first()->name) }}
                    @else
                    OFERTAS LIMITADAS
                    @endif
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                    Descuentos <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600">Irresistibles</span>
                </h2>
                <p class="mt-2 text-gray-600 text-sm md:text-base">Aprovecha precios especiales en productos seleccionados.</p>
            </div>

            <a href="{{ route('catalogo') }}" class="group flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-red-500 hover:text-red-600 transition-all shadow-sm hover:shadow-md">
                <span>Ver todo</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Grid de Productos -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($discountedProducts as $product)
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col border border-gray-100 overflow-hidden">

                <!-- Badge de Descuento -->
                <div class="absolute top-3 left-3 z-20">
                    <span class="bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-md flex items-center gap-1">
                        <i class="fas fa-tag text-[10px]"></i> -{{ $product->discount_percentage }}%
                    </span>
                </div>

                <!-- Imagen del Producto -->
                <div class="relative aspect-[4/3] overflow-hidden bg-gray-50">
                    <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                        @endif
                    </a>

                    <!-- Botón Hover (Desktop) -->
                    <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 hidden lg:block">
                        @if($product->stock > 0)
                        @php
                        $finalPrice = $product->has_discount ? $product->discount_price : $product->precio_venta;
                        @endphp
                        <button onclick="addToCart({{ $product->id }}, 1, {}, {{ $finalPrice }})"
                            class="w-full py-2.5 bg-white/90 backdrop-blur-sm hover:bg-red-600 text-gray-900 hover:text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                        @else
                        <button disabled class="w-full py-2.5 bg-gray-100 text-gray-400 font-bold rounded-xl cursor-not-allowed text-sm">
                            Agotado
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-4 flex flex-col flex-1">
                    <div class="mb-2">
                        @if ($product->category)
                        <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">{{ $product->category->name }}</span>
                        @endif
                        <a href="{{ route('shop.product', $product->slug) }}" class="block mt-1">
                            <h3 class="font-bold text-gray-900 text-sm md:text-base leading-tight line-clamp-2 group-hover:text-red-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                        </a>
                    </div>

                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 line-through font-medium">Q{{ number_format($product->precio_venta, 2) }}</span>
                            <span class="text-xl font-extrabold text-red-600">Q{{ number_format($product->discount_price, 2) }}</span>
                        </div>

                        <!-- Botón Móvil (Siempre visible) -->
                        <div class="lg:hidden">
                            @if($product->stock > 0)
                            @php
                            $finalPrice = $product->has_discount ? $product->discount_price : $product->precio_venta;
                            @endphp
                            <button onclick="addToCart({{ $product->id }}, 1, {}, {{ $finalPrice }})"
                                class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors shadow-sm">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif