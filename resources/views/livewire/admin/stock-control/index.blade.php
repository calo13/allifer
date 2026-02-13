<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-boxes text-indigo-600 mr-3"></i>
                    Control de Inventario
                </h1>
                <p class="mt-2 text-sm text-gray-600">Monitoreo en tiempo real de tu stock y movimientos</p>
            </div>
            <div class="flex items-center space-x-2">
                <button wire:click="exportExcel" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                    <i class="fas fa-file-excel mr-2"></i>
                    <span wire:loading.remove wire:target="exportExcel">Excel</span>
                    <span wire:loading wire:target="exportExcel">...</span>
                </button>
                <button wire:click="exportPdf" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                    <i class="fas fa-file-pdf mr-2"></i>
                    <span wire:loading.remove wire:target="exportPdf">PDF</span>
                    <span wire:loading wire:target="exportPdf">...</span>
                </button>
                <a href="{{ route('admin.stock-control.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Registrar Movimiento
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Productos -->
        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total Productos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cubes text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stock Bajo -->
        <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Stock Bajo</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['low_stock_count'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Movimientos Hoy -->
        <div class="bg-white border-l-4 border-orange-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Movimientos Hoy</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['total_movements_today'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Valor Inventario -->
        <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Valor Total</p>
                    <p class="text-2xl font-bold text-green-600">Q{{ number_format($stats['total_inventory_value'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Stock Bajo -->
    @if ($lowStockProducts->count() > 0)
    <div class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-red-800 mb-2">
                    {{ $lowStockProducts->count() }} producto(s) con stock bajo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    @foreach ($lowStockProducts->take(6) as $product)
                    <div class="bg-white rounded p-2 text-sm">
                        <span class="font-semibold text-red-900">{{ $product->name }}</span>
                        <span class="text-red-600">: {{ $product->stock }}/{{ $product->stock_minimo }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Stock por Variantes -->
    @if($productsWithVariants->count() > 0)
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
            <h3 class="font-bold text-indigo-900 flex items-center">
                <i class="fas fa-layer-group mr-2"></i>
                Stock por Variantes
            </h3>
            <p class="text-sm text-indigo-600">Productos que manejan stock por talla, color, etc.</p>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach($productsWithVariants as $product)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                            <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-indigo-600">{{ $product->stock }}</span>
                            <p class="text-xs text-gray-500">Total</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($product->variants as $variant)
                        <div class="flex items-center justify-between p-2 rounded-lg text-sm
                                        {{ $variant->stock <= 0 ? 'bg-red-50 border border-red-200' : ($variant->stock <= 5 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50 border border-gray-200') }}">
                            <span class="font-medium {{ $variant->stock <= 0 ? 'text-red-700' : 'text-gray-700' }}">
                                {{ $variant->value }}
                            </span>
                            <span class="font-bold {{ $variant->stock <= 0 ? 'text-red-600' : ($variant->stock <= 5 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ $variant->stock }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">
                        <a href="{{ route('admin.stock-control.product-history', $product->id) }}"
                            class="text-xs text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-history mr-1"></i> Ver historial
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Búsqueda -->
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nombre o SKU..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- Filtro por Tipo -->
            <select wire:model.live="filterType"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-white">
                <option value="">Todos los tipos</option>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
                <option value="ajuste">Ajuste</option>
                <option value="devolucion">Devolución</option>
            </select>

            <!-- Filtro por Fecha -->
            <input type="date" wire:model.live="filterDate"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="font-bold text-gray-900">
                <i class="fas fa-list mr-2"></i>
                Historial de Movimientos
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('created_at')"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:bg-gray-100">
                            <i class="fas fa-calendar mr-1"></i>Fecha
                            @if ($sortField === 'created_at')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-box mr-1"></i>Producto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-tag mr-1"></i>Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-sort-numeric-up mr-1"></i>Cantidad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-warehouse mr-1"></i>Stock
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-comment mr-1"></i>Motivo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-user mr-1"></i>Usuario
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-orange-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $movement->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $movement->product->name }}</div>
                            <span class="text-xs text-gray-500">SKU: {{ $movement->product->sku }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $typeConfig = [
                            'entrada' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-arrow-down'],
                            'salida' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-arrow-up'],
                            'ajuste' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-sync'],
                            'devolucion' => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-undo'],
                            ];
                            $config = $typeConfig[$movement->type] ?? ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-question'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $config['color'] }}">
                                <i class="fas {{ $config['icon'] }} mr-1"></i>{{ ucfirst($movement->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-lg font-bold {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="text-gray-600">{{ $movement->stock_antes }}</span>
                            <i class="fas fa-arrow-right mx-2 text-gray-400"></i>
                            <span class="font-bold text-gray-900">{{ $movement->stock_despues }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm max-w-xs">
                            <div class="font-medium text-gray-900 truncate" title="{{ $movement->motivo }}">
                                {{ $movement->motivo }}
                            </div>
                            @if ($movement->notas)
                            <div class="text-xs text-gray-500 mt-1 truncate" title="{{ $movement->notas }}">
                                {{ $movement->notas }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <i class="fas fa-user-circle mr-1"></i>{{ $movement->user->name ?? 'Sistema' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.stock-control.product-history', $movement->product_id) }}"
                                class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-xs">
                                <i class="fas fa-history mr-1"></i> Ver Historial
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No hay movimientos registrados</p>
                                <p class="text-sm text-gray-500">Los movimientos de inventario aparecerán aquí</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($movements->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $movements->links() }}
        </div>
        @endif
    </div>
</div>