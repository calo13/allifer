<div class="space-y-6">
    <!-- Header con filtros rápidos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-chart-bar text-primary-600 mr-2"></i>
                Reporte de Caja
            </h2>

            <!-- Filtros rápidos -->
            <div class="flex flex-wrap gap-2">
                <button wire:click="setRangoHoy"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium transition-colors">
                    <i class="fas fa-calendar-day mr-1"></i> Hoy
                </button>
                <button wire:click="setRangoAyer"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">
                    <i class="fas fa-calendar-minus mr-1"></i> Ayer
                </button>
                <button wire:click="setRangoSemana"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">
                    <i class="fas fa-calendar-week mr-1"></i> Esta Semana
                </button>
                <button wire:click="setRangoMes"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">
                    <i class="fas fa-calendar-alt mr-1"></i> Este Mes
                </button>

                <div class="h-8 w-px bg-gray-300 mx-1 hidden md:block"></div>

                <button wire:click="exportExcel" wire:loading.attr="disabled" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors" title="Exportar Excel">
                    <i class="fas fa-file-excel"></i>
                </button>
                <button wire:click="exportPdf" wire:loading.attr="disabled" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors" title="Exportar PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
            </div>
        </div>

        <!-- Filtro personalizado -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                <input type="date"
                    wire:model.live="fecha_inicio"
                    wire:change="calcularReporte"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                <input type="date"
                    wire:model.live="fecha_fin"
                    wire:change="calcularReporte"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex items-end">
                <button wire:click="calcularReporte"
                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                    <i class="fas fa-sync mr-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Tarjetas de totales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total General -->
        <div class="bg-gradient-to-br from-primary-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-wallet text-3xl opacity-80"></i>
                <span class="text-sm font-medium opacity-90">Total General</span>
            </div>
            <p class="text-3xl font-bold">Q{{ number_format($total_general, 2) }}</p>
            <p class="text-sm opacity-75 mt-1">{{ $numero_ventas }} ventas</p>
        </div>

        <!-- Efectivo -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-money-bill-wave text-3xl opacity-80"></i>
                <span class="text-sm font-medium opacity-90">Efectivo</span>
            </div>
            <p class="text-3xl font-bold">Q{{ number_format($total_efectivo, 2) }}</p>
            <p class="text-sm opacity-75 mt-1">
                {{ number_format(($total_general > 0 ? ($total_efectivo / $total_general) * 100 : 0), 1) }}% del total
            </p>
        </div>

        <!-- Tarjeta -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-credit-card text-3xl opacity-80"></i>
                <span class="text-sm font-medium opacity-90">Tarjeta</span>
            </div>
            <p class="text-3xl font-bold">Q{{ number_format($total_tarjeta, 2) }}</p>
            <p class="text-sm opacity-75 mt-1">
                {{ number_format(($total_general > 0 ? ($total_tarjeta / $total_general) * 100 : 0), 1) }}% del total
            </p>
        </div>

        <!-- Transferencia -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-exchange-alt text-3xl opacity-80"></i>
                <span class="text-sm font-medium opacity-90">Transferencia</span>
            </div>
            <p class="text-3xl font-bold">Q{{ number_format($total_transferencia, 2) }}</p>
            <p class="text-sm opacity-75 mt-1">
                {{ number_format(($total_general > 0 ? ($total_transferencia / $total_general) * 100 : 0), 1) }}% del total
            </p>
        </div>
    </div>

    <!-- Control de Efectivo -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-calculator text-green-600 mr-2"></i>
            Control de Efectivo
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600 mb-1">Efectivo Esperado</p>
                <p class="text-2xl font-bold text-gray-900">Q{{ number_format($total_efectivo, 2) }}</p>
            </div>

            <div class="bg-blue-50 rounded-lg p-4">
                <label class="block text-sm text-gray-600 mb-2">Efectivo Real Contado</label>
                <input type="number"
                    wire:model.live="efectivo_real"
                    step="0.01"
                    placeholder="0.00"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>

            <div class="rounded-lg p-4 {{ ($efectivo_real - $total_efectivo) == 0 ? 'bg-green-50' : (($efectivo_real - $total_efectivo) > 0 ? 'bg-blue-50' : 'bg-red-50') }}">
                <p class="text-sm text-gray-600 mb-1">Diferencia</p>
                <p class="text-2xl font-bold {{ ($efectivo_real - $total_efectivo) == 0 ? 'text-green-600' : (($efectivo_real - $total_efectivo) > 0 ? 'text-blue-600' : 'text-red-600') }}">
                    {{ ($efectivo_real - $total_efectivo) >= 0 ? '+' : '' }}Q{{ number_format($efectivo_real - $total_efectivo, 2) }}
                </p>
                <p class="text-xs text-gray-600 mt-1">
                    @if(($efectivo_real - $total_efectivo) == 0)
                    ✓ Cuadrado perfecto
                    @elseif(($efectivo_real - $total_efectivo) > 0)
                    ↑ Sobrante
                    @else
                    ↓ Faltante
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas por Vendedor -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-users text-purple-600 mr-2"></i>
                Ventas por Vendedor
            </h3>

            @if(count($ventas_por_vendedor) > 0)
            <div class="space-y-3">
                @foreach($ventas_por_vendedor as $venta)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($venta['nombre'], 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $venta['nombre'] }}</p>
                            <p class="text-sm text-gray-600">{{ $venta['cantidad'] }} ventas</p>
                        </div>
                    </div>
                    <p class="text-lg font-bold text-purple-600">Q{{ number_format($venta['total'], 2) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">No hay ventas en este período</p>
            @endif
        </div>

        <!-- Productos Más Vendidos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-600 mr-2"></i>
                Productos Más Vendidos
            </h3>

            @if(count($productos_mas_vendidos) > 0)
            <div class="space-y-3">
                @foreach($productos_mas_vendidos as $index => $producto)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $producto['product_name'] }}</p>
                            <p class="text-sm text-gray-600">{{ $producto['total_vendido'] }} unidades</p>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-green-600">Q{{ number_format($producto['ingresos'], 2) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">No hay productos vendidos en este período</p>
            @endif
        </div>
    </div>
</div>