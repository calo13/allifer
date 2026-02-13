<div>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.stock-control.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Control de Stock
            </a>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-plus-circle text-primary-600 mr-3"></i>
                Registrar Movimiento de Stock
            </h1>
            <p class="mt-2 text-sm text-gray-600">Registra entradas, salidas, ajustes o devoluciones de inventario</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <form wire:submit="save">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Producto -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-box text-primary-600 mr-2"></i> Producto *
                        </label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text"
                                wire:model.live.debounce.300ms="searchProduct"
                                placeholder="Buscar por nombre o SKU..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        </div>

                        <!-- Resultados de búsqueda -->
                        @if($searchProduct && $filteredProducts->count() > 0)
                        <div class="mt-2 max-h-48 overflow-y-auto border-2 border-gray-200 rounded-lg">
                            @foreach($filteredProducts as $product)
                            <div wire:click="selectProduct({{ $product->id }})" 
                                 class="p-3 hover:bg-primary-50 cursor-pointer border-b last:border-b-0 transition-colors {{ $product_id == $product->id ? 'bg-primary-100' : '' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-600">SKU: {{ $product->sku }}</span>
                                            @if($product->variants->count() > 0)
                                                <span class="text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full">
                                                    <i class="fas fa-layer-group mr-1"></i>{{ $product->variants->count() }} variantes
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium {{ $product->stock <= $product->stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                        Stock: {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Producto seleccionado -->
                        @if($selectedProduct)
                        <div class="mt-3 p-4 bg-primary-50 border-2 border-primary-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-primary-900">Producto seleccionado:</p>
                                    <p class="text-sm text-primary-700">{{ $selectedProduct->name }}</p>
                                    <p class="text-xs text-primary-600 mt-1">
                                        Stock total: <span class="font-bold">{{ $selectedProduct->stock }}</span> unidades
                                    </p>
                                </div>
                                <button type="button" wire:click="clearProduct" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <!-- Mostrar variantes si las tiene -->
                            @if($selectedProduct->variants->count() > 0)
                            <div class="mt-4 pt-4 border-t border-primary-200">
                                <p class="text-sm font-semibold text-primary-900 mb-2">
                                    <i class="fas fa-layer-group mr-2"></i>Stock por variante:
                                </p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    @foreach($selectedProduct->variants as $variant)
                                    <div class="text-xs bg-white p-2 rounded border {{ $variant->stock <= 5 ? 'border-red-300' : 'border-gray-200' }}">
                                        <span class="font-medium">{{ $variant->type }}: {{ $variant->value }}</span>
                                        <span class="block {{ $variant->stock <= 5 ? 'text-red-600' : 'text-green-600' }} font-bold">
                                            {{ $variant->stock }} uds
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        @error('product_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Selector de Variante (solo si el producto tiene variantes) -->
                    @if($selectedProduct && $selectedProduct->variants->count() > 0)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-layer-group text-primary-600 mr-2"></i> Variante 
                            @if($selectedProduct->stock_por_variante)
                                <span class="text-red-500">*</span>
                            @else
                                <span class="text-gray-400 text-xs">(Opcional)</span>
                            @endif
                        </label>
                        <select wire:model="variant_id" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white"
                                {{ $selectedProduct->stock_por_variante ? 'required' : '' }}>
                            <option value="">
                                {{ $selectedProduct->stock_por_variante ? 'Seleccionar variante...' : 'Aplicar a stock general' }}
                            </option>
                            @foreach($selectedProduct->variants as $variant)
                            <option value="{{ $variant->id }}">
                                {{ $variant->type }}: {{ $variant->value }} 
                                (Stock actual: {{ $variant->stock }})
                                @if($variant->precio_adicional > 0)
                                    (+Q{{ number_format($variant->precio_adicional, 2) }})
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @if($selectedProduct->stock_por_variante)
                        <p class="text-xs text-amber-600 mt-1">
                            <i class="fas fa-info-circle mr-1"></i> Este producto maneja stock por variante, debes seleccionar una.
                        </p>
                        @endif
                        @error('variant_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <!-- Tipo de Movimiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-exchange-alt text-primary-600 mr-2"></i> Tipo de Movimiento *
                        </label>
                        <select wire:model="type" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                            <option value="entrada">📥 Entrada (Aumenta stock)</option>
                            <option value="salida">📤 Salida (Reduce stock)</option>
                            <option value="ajuste">🔄 Ajuste (Corrección)</option>
                            <option value="devolucion">↩️ Devolución (Cliente devuelve)</option>
                        </select>
                        @error('type') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cantidad -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up text-primary-600 mr-2"></i> Cantidad *
                        </label>
                        <input type="number" 
                               wire:model="quantity" 
                               min="1" 
                               placeholder="0"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('quantity') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Motivo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clipboard text-primary-600 mr-2"></i> Motivo *
                        </label>
                        <input type="text" 
                               wire:model="motivo" 
                               placeholder="Ej: Compra a proveedor, Devolución de cliente, Producto dañado..."
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('motivo') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment text-primary-600 mr-2"></i> Notas Adicionales (Opcional)
                        </label>
                        <textarea wire:model="notas" 
                                  rows="3" 
                                  placeholder="Información adicional sobre el movimiento..."
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        @error('notas') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin.stock-control.index') }}" 
                       class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-lg transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i> Registrar Movimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
