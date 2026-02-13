<div>
    <div class="h-screen flex flex-col overflow-hidden">

        <!-- Header compacto con estadísticas -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-white border-l-4 border-blue-500 rounded-lg p-3 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600">Productos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($cart) }}</p>
                    </div>
                    <i class="fas fa-shopping-cart text-2xl text-blue-500"></i>
                </div>
            </div>
            <div class="bg-white border-l-4 border-green-500 rounded-lg p-3 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-green-600">Q{{ number_format($total, 2) }}</p>
                    </div>
                    <i class="fas fa-cash-register text-2xl text-green-500"></i>
                </div>
            </div>
            <div class="bg-white border-l-4 border-purple-500 rounded-lg p-3 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600">Cliente</p>
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $selectedCustomer['nombre'] }}</p>
                    </div>
                    <i class="fas fa-user text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if (session()->has('message'))
        <div class="mb-3 rounded-lg bg-green-50 border-l-4 border-green-500 p-3 shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="mb-3 rounded-lg bg-red-50 border-l-4 border-red-500 p-3 shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="flex-1 grid grid-cols-1 lg:grid-cols-3 gap-4 overflow-hidden">

            <!-- PANEL IZQUIERDO: Productos y Búsqueda -->
            <div class="lg:col-span-2 flex flex-col space-y-3 overflow-hidden">

                <!-- Búsqueda de Productos -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model.live.debounce.300ms="searchProduct"
                            placeholder="Buscar producto por nombre o escanear código..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Resultados de búsqueda -->
                    @if ($searchProduct && $products->count() > 0)
                    <div class="mt-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg">
                        @foreach ($products as $product)
                        <div wire:click="addToCart({{ $product->id }})"
                            class="p-3 hover:bg-primary-50 cursor-pointer border-b last:border-b-0 flex items-center justify-between transition-colors">
                            <div class="flex items-center space-x-3">
                                @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}"
                                    class="w-12 h-12 rounded object-cover">
                                @else
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">{{ $product->name }}</p>
                                    <div class="flex items-center space-x-2 mt-0.5">
                                        <span class="text-xs text-gray-500">SKU: {{ $product->sku }}</span>
                                        <span
                                            class="text-xs {{ $product->stock <= $product->stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                            Stock: {{ $product->stock }}
                                        </span>
                                        @if ($product->variants->count() > 0)
                                        <span
                                            class="text-xs bg-primary-100 text-primary-700 px-1.5 py-0.5 rounded">
                                            <i
                                                class="fas fa-layer-group mr-1"></i>{{ $product->variants->count() }}
                                            opciones
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($product->has_discount)
                                <p class="text-xs text-gray-400 line-through">
                                    Q{{ number_format($product->precio_venta, 2) }}
                                </p>
                                <p class="text-lg font-bold text-red-600">
                                    Q{{ number_format($product->discount_price, 2) }}
                                </p>
                                @else
                                <p class="text-lg font-bold text-primary-600">
                                    Q{{ number_format($product->precio_venta, 2) }}
                                </p>
                                @endif
                                <p class="text-xs text-gray-500">IVA inc.</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Carrito -->
                <div class="flex-1 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                    <div class="px-4 py-3 bg-primary-600 text-white flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            <h2 class="font-bold">Carrito ({{ count($cart) }})</h2>
                        </div>
                        @if (count($cart) > 0)
                        <button wire:click="$set('cart', [])" class="text-xs hover:bg-primary-700 px-2 py-1 rounded">
                            <i class="fas fa-trash mr-1"></i> Limpiar
                        </button>
                        @endif
                    </div>

                    <div class="flex-1 overflow-y-auto p-3 bg-gray-50">
                        @forelse($cart as $index => $item)
                        <div class="mb-2 p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900 truncate">{{ $item['name'] }}</p>
                                    @if (!empty($item['variant_text']))
                                    <p class="text-xs text-primary-600">{{ $item['variant_text'] }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">
                                        Q{{ number_format($item['precio_unitario'], 2) }} c/u</p>
                                </div>
                                <button wire:click="removeFromCart({{ $index }})"
                                    class="ml-2 text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-1">
                                    <button
                                        wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                        class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <span class="w-12 text-center font-bold">{{ $item['quantity'] }}</span>
                                    <button
                                        wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                        class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-lg font-bold text-primary-600">
                                    Q{{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                            <i class="fas fa-shopping-cart text-5xl mb-2 opacity-20"></i>
                            <p class="text-sm">Carrito vacío</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- PANEL DERECHO: Cliente y Totales COMPACTO -->
            <div class="flex flex-col space-y-3 overflow-y-auto">

                <!-- Cliente COMPACTO -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                    <h3 class="font-bold text-sm text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-user text-primary-600 mr-2"></i> Cliente
                    </h3>

                    <div class="mb-2">
                        <input type="text" wire:model.live.debounce.300ms="searchCustomer"
                            placeholder="Buscar cliente..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    @if ($searchCustomer && $customers->count() > 0)
                    <div class="mb-2 max-h-32 overflow-y-auto border border-gray-200 rounded-lg">
                        @foreach ($customers as $customer)
                        <div wire:click="selectCustomer({{ $customer->id }})"
                            class="p-2 hover:bg-primary-50 cursor-pointer border-b last:border-b-0">
                            <p class="font-semibold text-xs">{{ $customer->nombre }}</p>
                            <p class="text-xs text-gray-600">NIT: {{ $customer->nit }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <button wire:click="selectCustomer('CF')"
                        class="w-full mb-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs font-medium">
                        <i class="fas fa-user-slash mr-1"></i> Consumidor Final
                    </button>

                    <div class="p-2 bg-primary-50 rounded-lg border border-primary-200">
                        <p class="font-bold text-sm text-primary-900">{{ $selectedCustomer['nombre'] }}</p>
                        <p class="text-xs text-primary-700">NIT: {{ $selectedCustomer['nit'] }}</p>
                    </div>
                </div>

                <!-- Tipo de Documento COMPACTO -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                    <h3 class="font-bold text-sm text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-file-invoice text-blue-600 mr-2"></i> Documento
                    </h3>
                    <div class="space-y-2">
                        <label
                            class="flex items-center p-2 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $tipo_documento === 'ticket' ? 'border-primary-500 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio" wire:model="tipo_documento" value="ticket" class="mr-2">
                            <span class="text-sm">Ticket / Recibo</span>
                        </label>
                        <label
                            class="flex items-center p-2 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $tipo_documento === 'factura' ? 'border-primary-500 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio" wire:model="tipo_documento" value="factura" class="mr-2">
                            <span class="text-sm">Factura</span>
                        </label>
                    </div>
                </div>

                <!-- Método de Pago COMPACTO -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                    <h3 class="font-bold text-sm text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-credit-card text-green-600 mr-2"></i> Pago
                    </h3>
                    <select wire:model.live="metodo_pago"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white mb-3">
                        <option value="efectivo">💵 Efectivo</option>
                        <option value="tarjeta">💳 Tarjeta</option>
                        <option value="transferencia">🏦 Transferencia</option>
                    </select>

                    <!-- Campo de Monto Recibido (solo para efectivo) -->
                    <div wire:key="metodo-pago-{{ $metodo_pago }}">
                        @if ($metodo_pago === 'efectivo')
                        <div class="space-y-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    💰 Pago con:
                                </label>
                                <input type="number" wire:model.live="monto_recibido"
                                    wire:focus="$set('monto_recibido', '')" step="0.01" min="0"
                                    placeholder="0.00"
                                    class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-bold">
                            </div>

                            @if ($monto_recibido > 0)
                            <div
                                class="p-3 rounded-lg {{ $vuelto >= 0 ? 'bg-green-50 border-2 border-green-500' : 'bg-red-50 border-2 border-red-500' }}">
                                <p class="text-xs text-gray-600 mb-1">Vuelto:</p>
                                <p
                                    class="text-2xl font-bold {{ $vuelto >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                    Q{{ number_format($vuelto, 2) }}
                                </p>
                                @if ($vuelto < 0)
                                    <p class="text-xs text-red-600 mt-1">
                                    ⚠️ Falta: Q{{ number_format(abs($vuelto), 2) }}
                                    </p>
                                    @endif
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 text-center mt-2">
                            <p class="text-sm text-blue-700">
                                @if ($metodo_pago === 'tarjeta')
                                💳 Pago con tarjeta
                                @else
                                🏦 Pago por transferencia
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Totales COMPACTO -->
                <div class="bg-primary-600 rounded-lg shadow-lg text-white p-4 mt-3">
                    <div class="space-y-2 mb-3">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal:</span>
                            <span class="font-bold">Q{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>IVA (12%):</span>
                            <span class="font-bold">Q{{ number_format($iva, 2) }}</span>
                        </div>
                        <div class="border-t border-white/30 pt-2 flex justify-between">
                            <div>
                                <span class="font-semibold">TOTAL</span>
                                <p class="text-xs opacity-75">IVA incluido</p>
                            </div>
                            <span class="font-bold text-3xl">Q{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button wire:click="processSale"
                        class="w-full py-3 bg-white text-primary-600 font-bold rounded-lg hover:bg-gray-100 transition-all shadow-md">
                        <i class="fas fa-check-circle mr-2"></i> PROCESAR VENTA
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Variantes -->
    @if ($showVariantModal && $selectedProduct)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        wire:click.self="closeVariantModal">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <!-- Header -->
            <div class="bg-primary-600 text-white p-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-lg">Seleccionar Opciones</h3>
                    <button wire:click="closeVariantModal"
                        class="hover:bg-primary-700 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-primary-200 text-sm mt-1">{{ $selectedProduct->name }}</p>
            </div>

            <!-- Contenido -->
            <div class="p-4 space-y-4">
                @php
                $variantTypes = $selectedProduct->variants->groupBy('type');
                @endphp

                @foreach ($variantTypes as $type => $variants)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ $type }}:
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($variants as $variant)
                        <button type="button"
                            wire:click="selectVariant('{{ $type }}', '{{ $variant->value }}', {{ $variant->precio_adicional }})"
                            class="px-4 py-2 border-2 rounded-lg text-sm font-medium transition-all
                                    {{ isset($selectedVariants[$type]) && $selectedVariants[$type]['value'] === $variant->value
                                        ? 'border-primary-600 bg-primary-50 text-primary-700'
                                        : 'border-gray-200 hover:border-gray-300' }}">
                            {{ $variant->value }}
                            @if ($variant->precio_adicional > 0)
                            <span
                                class="text-xs text-green-600">(+Q{{ number_format($variant->precio_adicional, 2) }})</span>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Precio calculado -->
                <div class="bg-gray-50 rounded-lg p-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Precio:</span>
                        <span
                            class="text-2xl font-bold text-primary-600">Q{{ number_format($variantPrice, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-4 py-3 flex gap-3">
                <button wire:click="closeVariantModal"
                    class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium">
                    Cancelar
                </button>
                <button wire:click="addToCartWithVariant"
                    class="flex-1 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium">
                    <i class="fas fa-cart-plus mr-2"></i>Agregar
                </button>
            </div>
        </div>
    </div>
    @endif
    <!-- Modal de Crear Cliente -->
    @livewire('admin.pos.create-customer-modal')
</div>

@script
<script>
    $wire.on('open-pdf', (event) => {
        const saleId = event.saleId;
        window.open('/admin/pos/print/' + saleId, '_blank');
    });
</script>
@endscript