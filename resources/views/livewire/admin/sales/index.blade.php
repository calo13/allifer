<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-shopping-bag text-green-600 mr-3"></i>
                    Historial de Ventas
                </h1>
                <p class="mt-2 text-sm text-gray-600">Consulta y gestiona todas las ventas realizadas</p>
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
                <a href="{{ route('admin.pos.index') }}"
                    class="inline-flex items-center px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                    <i class="fas fa-cash-register mr-2"></i>
                    Ir al POS
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Ventas Hoy -->
        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Ventas Hoy</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_ventas_hoy'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Monto Hoy -->
        <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Ventas Hoy</p>
                    <p class="text-2xl font-bold text-green-600">Q{{ number_format($stats['monto_ventas_hoy'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Ventas Mes -->
        <div class="bg-white border-l-4 border-purple-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Ventas del Mes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_ventas_mes'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Monto Mes -->
        <div class="bg-white border-l-4 border-orange-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Ventas del Mes</p>
                    <p class="text-2xl font-bold text-orange-600">Q{{ number_format($stats['monto_ventas_mes'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Búsqueda -->
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por folio, cliente o NIT..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>

            <!-- Tipo Documento -->
            <select wire:model.live="filterTipoDocumento"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los documentos</option>
                <option value="ticket">Ticket</option>
                <option value="factura">Factura</option>
            </select>

            <!-- Método Pago -->
            <select wire:model.live="filterMetodoPago"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los métodos</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>

            <!-- Rango de Fechas -->
            <div class="flex items-center space-x-2">
                <input type="date"
                    wire:model.live="filterFechaInicio"
                    class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <span class="text-gray-500">-</span>
                <input type="date"
                    wire:model.live="filterFechaFin"
                    class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-hashtag mr-1"></i>Folio
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-calendar mr-1"></i>Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-user mr-1"></i>Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-file-invoice mr-1"></i>Documento
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-credit-card mr-1"></i>Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-box mr-1"></i>Items
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-dollar-sign mr-1"></i>Total
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-primary-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold text-primary-600">{{ $sale->folio }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $sale->fecha_venta->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $sale->nombre_cliente }}</div>
                            <div class="text-xs text-gray-500">NIT: {{ $sale->nit_cliente }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $sale->tipo_documento === 'factura' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-{{ $sale->tipo_documento === 'factura' ? 'file-invoice' : 'receipt' }} mr-1"></i>
                                {{ ucfirst($sale->tipo_documento) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ ucfirst($sale->metodo_pago) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                            {{ $sale->items->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-lg font-bold text-green-600">Q{{ number_format($sale->total, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.pos.print', $sale->id) }}"
                                target="_blank"
                                class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-xs">
                                <i class="fas fa-print mr-1"></i> Imprimir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No hay ventas registradas</p>
                                <p class="text-sm text-gray-500">Las ventas aparecerán aquí una vez que se realicen</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($sales->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>