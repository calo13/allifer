<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">Inicio</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('catalogo') }}" class="text-gray-500 hover:text-indigo-600">Catálogo</a>
            @if ($product->category)
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-700">{{ $product->category->name }}</span>
            @endif
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-6">
                <!-- Galería de imágenes -->
                <div class="flex gap-4">
                    <!-- Miniaturas laterales -->
                    @if ($product->images->count() > 1)
                    <div class="flex flex-col gap-2 w-20">
                        @foreach ($product->images as $index => $image)
                        <button wire:click="selectImage({{ $index }})"
                            class="w-20 h-20 rounded-lg overflow-hidden border-2 transition-all flex-shrink-0 {{ $selectedImage === $index ? 'border-indigo-600 ring-2 ring-indigo-200' : 'border-gray-200 hover:border-gray-300' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt=""
                                class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif

                    <!-- Imagen principal con zoom -->
                    <div class="flex-1 bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center p-4 min-h-[400px] relative group cursor-zoom-in"
                        x-data="{ zoomed: false, x: 50, y: 50 }"
                        @mousemove="x = ($event.offsetX / $el.offsetWidth) * 100; y = ($event.offsetY / $el.offsetHeight) * 100"
                        @mouseenter="zoomed = true" @mouseleave="zoomed = false">

                        @if ($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images[$selectedImage]->image_path) }}"
                            alt="{{ $product->name }}"
                            class="max-w-full max-h-[500px] object-contain transition-transform duration-200"
                            :style="zoomed ? 'transform: scale(2); transform-origin: ' + x + '% ' + y + '%' : ''">
                        @elseif($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="max-w-full max-h-[500px] object-contain transition-transform duration-200"
                            :style="zoomed ? 'transform: scale(2); transform-origin: ' + x + '% ' + y + '%' : ''">
                        @else
                        <div class="flex items-center justify-center">
                            <i class="fas fa-box text-gray-300 text-6xl"></i>
                        </div>
                        @if($product->has_discount)
                        <span class="absolute top-4 left-4 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg z-10">
                            OFERTA
                        </span>
                        @endif
                        @endif

                        <!-- Indicador de zoom -->
                        <div
                            class="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-search-plus mr-1"></i>Zoom
                        </div>
                    </div>
                </div>

                <!-- Info del producto -->
                <div class="space-y-6">
                    <div>
                        @if ($product->category)
                        <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                            {{ $product->category->name }}
                        </span>
                        @endif
                        <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $product->name }}</h1>
                        @if ($product->sku)
                        <p class="text-sm text-gray-500 mt-1">SKU: {{ $product->sku }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-3xl font-bold text-indigo-600">
                            Q{{ number_format($this->finalPrice, 2) }}
                        </div>

                        @if ($product->has_discount)
                        <div class="flex flex-col">
                            <span class="text-sm font-normal text-gray-400 line-through">
                                Q{{ number_format($product->precio_venta, 2) }}
                            </span>
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">
                                -{{ $product->discount_percentage }}% OFF
                            </span>
                        </div>
                        @endif
                    </div>

                    @if ($product->description)
                    <p class="text-gray-600">{{ $product->description }}</p>
                    @endif

                    <!-- Variantes -->
                    @if ($product->variants->count() > 0)
                    @php
                    $variantTypes = $product->variants->groupBy('type');
                    @endphp
                    @foreach ($variantTypes as $type => $variants)
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2 capitalize">{{ $type }}:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($variants as $variant)
                            <button
                                wire:click="$set('selectedVariants.{{ $type }}', '{{ $variant->value }}')"
                                class="px-4 py-2 border-2 rounded-lg text-sm font-medium transition-all {{ ($selectedVariants[$type] ?? '') === $variant->value ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-gray-200 hover:border-gray-300' }}">
                                {{ $variant->value }}
                                @if ($variant->precio_adicional > 0)
                                <span
                                    class="text-xs text-gray-500">(+Q{{ number_format($variant->precio_adicional, 2) }})</span>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <!-- Cantidad -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad:</label>
                        <div class="flex items-center gap-3">
                            <button wire:click="decrementQuantity"
                                class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="w-12 text-center text-lg font-semibold">{{ $quantity }}</span>
                            <button wire:click="incrementQuantity"
                                class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus"></i>
                            </button>
                            <span class="text-sm text-gray-500">({{ $this->availableStock }} disponibles)</span>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-3 pt-4">
                        {{-- <button onclick="addToCart({{ $product->id }}, {{ $quantity }}, {{ json_encode($selectedVariants) }})"
                        class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-cart-plus mr-2"></i>Agregar al carrito
                        </button> --}}
                        <button wire:click="addToCart"
                            class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all">
                            <i class="fas fa-cart-plus mr-2"></i>Agregar al carrito
                        </button>
                        <a href="https://wa.me/50249075678?text=Hola,%20me%20interesa:%20{{ urlencode($product->name) }}"
                            target="_blank"
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-all">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos relacionados -->
        @if ($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Productos relacionados</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($relatedProducts as $related)
                <a href="{{ route('shop.product', $related->slug) }}"
                    class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg transition-all">
                    <div class="aspect-square bg-gray-100">
                        @if ($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                            class="max-w-full max-h-[500px] object-contain">
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-sm text-gray-900 truncate">{{ $related->name }}</h3>
                        <p class="text-indigo-600 font-bold">Q{{ number_format($related->precio_venta, 2) }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>