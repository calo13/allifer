<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    Nuevo Producto
                </h1>
                <p class="mt-2 ml-16 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500 mr-1"></i>
                    Completa la información del producto para agregarlo al inventario
                </p>
            </div>
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 hover:border-primary-500 text-gray-700 hover:text-primary-600 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al listado
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COLUMNA IZQUIERDA (2/3) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Información Básica -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Información Básica</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- SKU -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-barcode text-primary-500 mr-1"></i>SKU (opcional)
                            </label>
                            <input type="text" wire:model="sku" placeholder="Ej: PROD-00001"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all">
                            <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-magic text-purple-400 mr-1"></i>
                                Se generará automáticamente si lo dejas vacío
                            </p>
                            @error('sku')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Código de Barras -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-qrcode text-primary-500 mr-1"></i>Código de Barras
                            </label>
                            <input type="text" wire:model="barcode" placeholder="Ej: 7501055301120"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all">
                            @error('barcode')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-primary-500 mr-1"></i>Nombre del Producto *
                        </label>
                        <input type="text" wire:model="name" placeholder="Ej: Coca Cola 355ml"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all">
                        @error('name')
                            <span class="text-red-500 text-xs flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left text-primary-500 mr-1"></i>Descripción
                        </label>
                        <textarea wire:model="description" rows="3" placeholder="Agrega detalles adicionales del producto..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all resize-none"></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Precios -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Precios</h2>
                        <span class="ml-auto text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">
                            <i class="fas fa-info-circle mr-1"></i>Incluye IVA 12%
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Precio Costo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign text-blue-500 mr-1"></i>Precio Costo (Q)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Q</span>
                                <input type="number" step="0.01" wire:model="precio_costo" placeholder="0.00"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            </div>
                            @error('precio_costo')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Precio Venta -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>Precio Venta (Q) *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-600 font-bold">Q</span>
                                <input type="number" step="0.01" wire:model="precio_venta" placeholder="0.00"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-lg border-2 border-green-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all font-medium">
                            </div>
                            @error('precio_venta')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Precio Mayorista -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-users text-purple-500 mr-1"></i>Precio Mayorista (Q)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Q</span>
                                <input type="number" step="0.01" wire:model="precio_mayorista" placeholder="Opcional"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                            </div>
                            @error('precio_mayorista')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventario y Variantes (JUNTOS) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-boxes text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Inventario y Variantes</h2>
                    </div>

                    <!-- Toggle: Stock por variante -->
                    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="stockPorVariante" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            <span class="ms-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-layer-group text-amber-600 mr-1"></i>
                                Manejar stock por variante
                            </span>
                        </label>
                        <p class="mt-2 text-xs text-amber-700">
                            @if($stockPorVariante)
                                <i class="fas fa-info-circle mr-1"></i>
                                El stock total se calculará sumando el stock de cada variante.
                            @else
                                <i class="fas fa-info-circle mr-1"></i>
                                Stock único para todo el producto, las variantes son solo presentación.
                            @endif
                        </p>
                    </div>

                    <!-- Stock General -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Stock Actual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-cubes text-orange-500 mr-1"></i>
                                Stock Actual {{ $stockPorVariante ? '(Calculado)' : '*' }}
                            </label>
                            @if($stockPorVariante && count($variants) > 0)
                                <div class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-100 text-gray-600 font-medium">
                                    {{ collect($variants)->sum('stock') }} unidades
                                    <span class="text-xs text-gray-500 ml-1">(suma de variantes)</span>
                                </div>
                            @else
                                <input type="number" wire:model="stock" placeholder="0"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all"
                                    {{ $stockPorVariante ? 'disabled' : '' }}>
                            @endif
                            @error('stock')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Stock Mínimo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>Stock Mínimo
                            </label>
                            <input type="number" wire:model="stock_minimo" placeholder="5"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all">
                            <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-bell text-yellow-400 mr-1"></i>Te avisaremos cuando el stock esté bajo
                            </p>
                            @error('stock_minimo')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Separador Variantes -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-palette text-white text-sm"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">Variantes del Producto</h3>
                            <span class="ml-auto text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                {{ count($variants) }} variante(s)
                            </span>
                        </div>

                        <!-- Lista de variantes existentes -->
                        @if(count($variants) > 0)
                            <div class="space-y-2 mb-4 max-h-64 overflow-y-auto pr-1">
                                @foreach($variants as $index => $variant)
                                    <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-lg p-3 hover:shadow-sm transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <!-- Icono según tipo -->
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center
                                                    @if($variant['type'] == 'Color') bg-pink-100 text-pink-600
                                                    @elseif($variant['type'] == 'Talla') bg-blue-100 text-blue-600
                                                    @elseif($variant['type'] == 'Sabor') bg-green-100 text-green-600
                                                    @else bg-purple-100 text-purple-600 @endif">
                                                    @if($variant['type'] == 'Color')
                                                        <i class="fas fa-palette text-sm"></i>
                                                    @elseif($variant['type'] == 'Talla')
                                                        <i class="fas fa-ruler text-sm"></i>
                                                    @elseif($variant['type'] == 'Sabor')
                                                        <i class="fas fa-cookie-bite text-sm"></i>
                                                    @else
                                                        <i class="fas fa-expand-arrows-alt text-sm"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $variant['type'] }}</span>
                                                    <p class="font-medium text-gray-900">{{ $variant['value'] }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <!-- Precio adicional -->
                                                <div class="text-right">
                                                    <span class="text-xs text-gray-500">Precio extra</span>
                                                    <p class="font-medium {{ ($variant['precio_adicional'] ?? 0) > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                                        {{ ($variant['precio_adicional'] ?? 0) > 0 ? '+Q' . number_format($variant['precio_adicional'], 2) : 'Q0.00' }}
                                                    </p>
                                                </div>
                                                <!-- Stock de variante -->
                                                @if($stockPorVariante)
                                                    <div class="text-right">
                                                        <span class="text-xs text-gray-500">Stock</span>
                                                        <p class="font-medium {{ ($variant['stock'] ?? 0) > 0 ? 'text-blue-600' : 'text-red-500' }}">
                                                            {{ $variant['stock'] ?? 0 }} uds
                                                        </p>
                                                    </div>
                                                @endif
                                                <!-- Botón eliminar -->
                                                <button type="button" wire:click="removeVariant({{ $index }})"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-lg mb-4">
                                <i class="fas fa-layer-group text-3xl text-gray-300 mb-2"></i>
                                <p class="text-sm text-gray-500">No hay variantes agregadas</p>
                                <p class="text-xs text-gray-400 mt-1">Agrega tallas, colores, sabores, etc.</p>
                            </div>
                        @endif

                        <!-- Formulario agregar variante -->
                        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                            <p class="text-xs font-medium text-primary-700 mb-3">
                                <i class="fas fa-plus-circle mr-1"></i>Agregar nueva variante
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <!-- Tipo -->
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Tipo</label>
                                    <select wire:model="newVariantType" 
                                        class="w-full text-sm rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200">
                                        <option value="">Seleccionar...</option>
                                        <option value="Talla">Talla</option>
                                        <option value="Color">Color</option>
                                        <option value="Sabor">Sabor</option>
                                        <option value="Tamaño">Tamaño</option>
                                    </select>
                                </div>
                                <!-- Valor -->
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Valor</label>
                                    <input type="text" wire:model="newVariantValue" placeholder="Ej: XL, Rojo"
                                        class="w-full text-sm rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200">
                                </div>
                                <!-- Precio adicional -->
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Precio extra (Q)</label>
                                    <input type="number" wire:model="newVariantPrice" placeholder="0.00" step="0.01"
                                        class="w-full text-sm rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200">
                                </div>
                                <!-- Stock -->
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">
                                        Stock {{ !$stockPorVariante ? '(opcional)' : '' }}
                                    </label>
                                    <input type="number" wire:model="newVariantStock" placeholder="0"
                                        class="w-full text-sm rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-200">
                                </div>
                            </div>
                            <button type="button" wire:click="addVariant"
                                class="mt-3 w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-all flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>Agregar Variante
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA (1/3) - Sidebar -->
            <div class="space-y-6">

                <!-- Galería de Imágenes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Imágenes</h2>
                    </div>

                    <!-- Imagen principal -->
                    @if($image)
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-green-600 mb-2">
                                <i class="fas fa-check-circle mr-1"></i>Imagen Principal
                            </label>
                            <div class="relative group w-full h-40 rounded-lg overflow-hidden ring-2 ring-green-400">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                <button type="button" wire:click="$set('image', null)"
                                    class="absolute inset-0 bg-red-500/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-trash text-white text-xl"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Imágenes adicionales preview -->
                    @if($additionalImages && count($additionalImages) > 0)
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-purple-600 mb-2">
                                <i class="fas fa-images mr-1"></i>Imágenes Adicionales ({{ count($additionalImages) }})
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($additionalImages as $index => $img)
                                    <div class="relative group aspect-square rounded-lg overflow-hidden ring-2 ring-purple-300">
                                        <img src="{{ $img->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <button type="button" wire:click="removeAdditionalImage({{ $index }})"
                                            class="absolute inset-0 bg-red-500/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <i class="fas fa-trash text-white"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Botones de subida -->
                    <div class="space-y-3">
                        <!-- Subir imagen principal -->
                        @if(!$image)
                            <label class="flex flex-col items-center justify-center h-32 border-2 border-dashed border-primary-300 rounded-xl cursor-pointer hover:bg-primary-50 hover:border-primary-400 transition-all group">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-purple-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-camera text-xl text-primary-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-primary-600">Imagen principal</span>
                                <span class="text-xs text-gray-400">Toca para usar cámara o galería</span>
                                <input type="file" wire:model="image" accept="image/*" capture="environment" class="hidden">
                            </label>
                        @endif

                        <!-- Subir imágenes adicionales -->
                        <label class="flex items-center justify-center h-20 border-2 border-dashed border-purple-300 rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-400 transition-all group">
                            <div class="text-center">
                                <i class="fas fa-plus text-purple-400 group-hover:text-purple-600 mr-2"></i>
                                <span class="text-sm text-gray-600 group-hover:text-purple-600">Agregar más imágenes</span>
                                <span class="text-xs text-gray-400 block">Máximo 4 adicionales</span>
                            </div>
                            <input type="file" wire:model="additionalImages" accept="image/*" multiple capture="environment" class="hidden">
                        </label>
                    </div>

                    @error('image')
                        <span class="text-red-500 text-xs flex items-center mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                    @error('additionalImages.*')
                        <span class="text-red-500 text-xs flex items-center mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Categorización -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-layer-group text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Categorización</h2>
                    </div>

                    <!-- Categoría -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-purple-500 mr-1"></i>Categoría
                        </label>
                        <select wire:model="category_id" data-tom-select="category"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Sin categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-xs flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-copyright text-blue-500 mr-1"></i>Marca
                        </label>
                        <select wire:model="brand_id" data-tom-select="brand"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Sin marca</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="text-red-500 text-xs flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Proveedor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-truck text-green-500 mr-1"></i>Proveedor
                        </label>
                        <select wire:model="supplier_id" data-tom-select="supplier"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Sin proveedor</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="text-red-500 text-xs flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="space-y-3">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Producto
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 hover:text-gray-900 font-medium rounded-xl hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
