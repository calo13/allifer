<div>
    <!-- Header mejorado con gradiente -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-box-open text-primary-600 mr-3"></i>
                    Productos
                </h1>
                <p class="mt-2 text-sm text-gray-600">Gestiona tu inventario de productos de forma eficiente</p>
            </div>

            <div class="flex items-center space-x-2">
                <button wire:click="exportExcel" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-file-excel mr-2"></i>
                    <span wire:loading.remove wire:target="exportExcel">Excel</span>
                    <span wire:loading wire:target="exportExcel">...</span>
                </button>

                <button wire:click="exportPdf" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-file-pdf mr-2"></i>
                    <span wire:loading.remove wire:target="exportPdf">PDF</span>
                    <span wire:loading wire:target="exportPdf">...</span>
                </button>

                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-sm font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Nuevo
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message con animación -->
    @if (session()->has('message'))
    <div class="mb-6 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
        </div>
    </div>
    @endif

    <!-- Warning Message -->
    @if (session()->has('warning'))
    <div class="mb-6 rounded-xl bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 p-4 shadow-sm animate-fade-in">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3"></i>
            <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
        </div>
    </div>
    @endif

    <!-- Search & Filters mejorado -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nombre, SKU o código de barras..."
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>
            <div class="flex items-center space-x-3">
                <i class="fas fa-filter text-gray-400"></i>
                <select wire:model.live="perPage"
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                    <option value="10">10 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                    <option value="100">100 por página</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Table mejorada -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-image mr-2"></i>Imagen
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-box mr-2"></i>Producto
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-tag mr-2"></i>Categoría
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-dollar-sign mr-2"></i>Precio
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-warehouse mr-2"></i>Stock
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-toggle-on mr-2"></i>Estado
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-cog mr-2"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                    <tr class="hover:bg-gradient-to-r hover:from-primary-50 hover:to-purple-50 transition-all duration-200 {{ !$product->active ? 'opacity-60' : '' }}">
                        <!-- Imagen mejorada -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-16 w-16 rounded-xl object-cover shadow-md ring-2 ring-gray-200 hover:ring-primary-400 transition-all">
                            @else
                            <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm">
                                <i class="fas fa-box-open text-2xl text-gray-400"></i>
                            </div>
                            @endif
                        </td>

                        <!-- Producto mejorado -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-semibold text-gray-900 hover:text-primary-600 transition-colors">
                                    {{ $product->name }}
                                </div>
                                <div class="flex items-center mt-1 space-x-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                        <i class="fas fa-barcode mr-1"></i>{{ $product->sku }}
                                    </span>
                                    @if ($product->barcode)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-qrcode mr-1"></i>{{ $product->barcode }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Categoría mejorada -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-purple-100 text-purple-800 shadow-sm">
                                <i class="fas fa-tag mr-1.5"></i>
                                {{ $product->category->name }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400 italic">Sin categoría</span>
                            @endif
                        </td>

                        <!-- Precio mejorado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-base font-bold text-gray-900">
                                    <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>
                                    Q {{ number_format($product->precio_venta, 2) }}
                                </div>
                                @if ($product->precio_mayorista)
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-users text-blue-500 mr-1"></i>
                                    Mayor: Q {{ number_format($product->precio_mayorista, 2) }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Stock mejorado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="flex items-center">
                                    @if ($product->stockBajo())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800 shadow-sm animate-pulse">
                                        <i class="fas fa-exclamation-triangle mr-1.5"></i>
                                        {{ $product->stock }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800 shadow-sm">
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                        {{ $product->stock }}
                                    </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-chart-line mr-1"></i>Mín: {{ $product->stock_minimo }}
                                </div>
                            </div>
                        </td>

                        <!-- Estado mejorado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->active)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-md">
                                <i class="fas fa-check-circle mr-1.5"></i>Activo
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-md">
                                <i class="fas fa-times-circle mr-1.5"></i>Inactivo
                            </span>
                            @endif
                        </td>

                        <!-- Acciones mejoradas -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @if (!$product->active)
                                <button wire:click="toggleActive({{ $product->id }})"
                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Reactivar
                                </button>
                                @endif

                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-primary-600 hover:from-blue-600 hover:to-primary-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>

                                @if ($product->active)
                                <button onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')"
                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    Eliminar
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-box-open text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-medium text-gray-900 mb-2">No se encontraron productos</p>
                                <p class="text-sm text-gray-500 mb-4">Comienza agregando tu primer producto al inventario</p>
                                @if ($search)
                                <button wire:click="$set('search', '')"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class="fas fa-times mr-2"></i>
                                    Limpiar búsqueda
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination mejorada -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>