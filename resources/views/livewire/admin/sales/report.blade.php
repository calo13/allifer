<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line text-primary-600 mr-3"></i>
                    Reporte Contable
                </h1>
                <p class="mt-2 text-sm text-gray-600">Análisis de ventas, costos y ganancias</p>
            </div>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Período de Análisis</h3>
            <div class="flex items-center space-x-2">
                <input type="date" 
                    wire:model="filterFechaInicio"
                       class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                <span class="text-gray-500">a</span>
                <input type="date" 
                      wire:model="filterFechaFin"
                       class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2">
            <button wire:click="setPeriodo('hoy')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filterPeriodo === 'hoy' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Hoy
            </button>
            <button wire:click="setPeriodo('ayer')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filterPeriodo === 'ayer' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Ayer
            </button>
            <button wire:click="setPeriodo('semana')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filterPeriodo === 'semana' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Esta Semana
            </button>
            <button wire:click="setPeriodo('mes')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filterPeriodo === 'mes' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Este Mes
            </button>
            <button wire:click="setPeriodo('ano')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filterPeriodo === 'ano' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Este Año
            </button>
        </div>
    </div>

    <!-- Resumen Financiero -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Ventas -->
        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Total Ventas</p>
            <p class="text-3xl font-bold text-blue-600">Q{{ number_format($totalVentas, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $sales->count() }} ventas realizadas</p>
        </div>

        <!-- Costo Total -->
        <div class="bg-white border-l-4 border-orange-500 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-orange-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Costo de Ventas</p>
            <p class="text-3xl font-bold text-orange-600">Q{{ number_format($totalCostos, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Inversión en productos</p>
        </div>

        <!-- Ganancia -->
        <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Ganancia Bruta</p>
            <p class="text-3xl font-bold text-green-600">Q{{ number_format($totalGanancias, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Utilidad generada</p>
        </div>

        <!-- Margen -->
        <div class="bg-white border-l-4 border-purple-500 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percent text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Margen de Ganancia</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($margenGanancia, 1) }}%</p>
            <p class="text-xs text-gray-500 mt-1">Rentabilidad</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productos Más Vendidos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top 5 Productos Más Vendidos
            </h3>
            <div class="space-y-3">
                @forelse($productosVendidos as $producto)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-bold text-sm">{{ $loop->iteration }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $producto->product_name }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                        {{ $producto->total_vendido }} unidades
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>

        <!-- Ventas por Día -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                Ventas por Día
            </h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @forelse($ventasPorDia as $venta)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $venta->total_ventas }} ventas</p>
                    </div>
                    <span class="text-lg font-bold text-primary-600">Q{{ number_format($venta->total_monto, 2) }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
