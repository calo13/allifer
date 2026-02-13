<div class="space-y-6">

    <!-- Action Center & Saludo -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chart-line text-primary-600 mr-2"></i>
                Dashboard
            </h1>
            <p class="text-gray-600 mt-1">
                <i class="fas fa-calendar-day mr-1"></i>
                Bienvenido de nuevo, {{ Auth::user()->name }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            <!-- Action Center -->
            <div class="flex gap-2">
                @if(count($ordenes_pendientes) > 0)
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 bg-amber-100 text-amber-800 px-4 py-2 rounded-lg hover:bg-amber-200 transition-colors shadow-sm">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    <span class="font-bold">{{ count($ordenes_pendientes) }}</span> Pedidos Web
                    <i class="fas fa-arrow-right text-xs ml-1"></i>
                </a>
                @endif

                @if($productos_stock_bajo->count() > 0)
                <a href="{{ route('admin.stock-control.index') }}" class="flex items-center gap-2 bg-red-100 text-red-800 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors shadow-sm">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="font-bold">{{ $productos_stock_bajo->count() }}</span> Stock Bajo
                </a>
                @endif
            </div>

            <div class="text-right hidden md:block">
                <p class="text-sm text-gray-600">{{ now()->format('l, d F Y') }}</p>
                <p class="text-lg font-bold text-primary-600">{{ now()->format('h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Ventas Hoy -->
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <i class="fas fa-cash-register text-2xl"></i>
                </div>
                <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Global</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Ventas Totales (POS + Web)</p>
            <p class="text-3xl font-bold mb-2">Q{{ number_format($ventas_hoy, 2) }}</p>
            <div class="flex items-center text-sm">
                @if($cambio_ventas >= 0)
                <i class="fas fa-arrow-up mr-1"></i>
                <span>+{{ number_format($cambio_ventas, 1) }}%</span>
                @else
                <i class="fas fa-arrow-down mr-1"></i>
                <span>{{ number_format($cambio_ventas, 1) }}%</span>
                @endif
                <span class="ml-1 opacity-75">vs ayer</span>
            </div>
        </div>

        <!-- Ganancias -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Hoy</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Ganancias</p>
            <p class="text-3xl font-bold mb-2">Q{{ number_format($ganancias_hoy, 2) }}</p>
            <div class="flex items-center text-sm">
                <i class="fas fa-percentage mr-1"></i>
                <span>Margen: {{ number_format($margen_ganancia, 1) }}%</span>
            </div>
        </div>

        <!-- Transacciones -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
                <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Hoy</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Transacciones</p>
            <p class="text-3xl font-bold mb-2">{{ $transacciones_hoy }}</p>
            <div class="flex items-center text-sm">
                <i class="fas fa-shopping-bag mr-1"></i>
                <span>ventas realizadas</span>
            </div>
        </div>

        <!-- Ticket Promedio -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <i class="fas fa-ticket-alt text-2xl"></i>
                </div>
                <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Hoy</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Ticket Promedio</p>
            <p class="text-3xl font-bold mb-2">Q{{ number_format($ticket_promedio, 2) }}</p>
            <div class="flex items-center text-sm">
                <i class="fas fa-chart-bar mr-1"></i>
                <span>por transacción</span>
            </div>
        </div>
    </div>

    <!-- Gráfica de Ventas Semana -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">
                <i class="fas fa-chart-area text-primary-600 mr-2"></i>
                Ventas de los Últimos 7 Días
            </h3>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <i class="fas fa-calendar-week"></i>
                <span>Últimos 7 días</span>
            </div>
        </div>
        <canvas id="ventasSemanaChart" height="80"></canvas>
    </div>

    <!-- Top Productos + Métodos de Pago -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Top Productos -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top 5 Productos Hoy
            </h3>

            @if(count($top_productos) > 0)
            <div class="space-y-3">
                @foreach($top_productos as $index => $producto)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg hover:shadow-md transition-shadow border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $producto['product_name'] }}</p>
                            <p class="text-sm text-gray-600">
                                <i class="fas {{ isset($producto['source']) && $producto['source'] === 'web' ? 'fa-globe text-blue-500' : 'fa-store text-gray-500' }} mr-1"></i>
                                {{ $producto['total'] }} unidades vendidas
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-500"
                                style="width: {{ ($producto['total'] / max(array_column($top_productos, 'total'))) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-box-open text-5xl mb-3 opacity-20"></i>
                <p class="text-sm">No hay ventas hoy</p>
            </div>
            @endif
        </div>

        <!-- Métodos de Pago -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                <i class="fas fa-wallet text-blue-600 mr-2"></i>
                Ventas por Método de Pago
            </h3>

            <div class="flex items-center justify-center mb-6">
                <canvas id="metodosPagoChart" width="250" height="250"></canvas>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="font-medium text-gray-700">
                            <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>
                            Efectivo
                        </span>
                    </div>
                    <span class="font-bold text-green-700">Q{{ number_format($ventas_efectivo, 2) }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="font-medium text-gray-700">
                            <i class="fas fa-credit-card text-blue-600 mr-1"></i>
                            Tarjeta
                        </span>
                    </div>
                    <span class="font-bold text-blue-700">Q{{ number_format($ventas_tarjeta, 2) }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                        <span class="font-medium text-gray-700">
                            <i class="fas fa-exchange-alt text-orange-600 mr-1"></i>
                            Transferencia
                        </span>
                    </div>
                    <span class="font-bold text-orange-700">Q{{ number_format($ventas_transferencia, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contadores + Stock Bajo -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Contadores Rápidos -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="fas fa-chart-pie text-primary-600 mr-2"></i>
                Inventario
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-box text-blue-600"></i>
                        <span class="text-sm text-gray-700">Productos</span>
                    </div>
                    <span class="font-bold text-blue-700">{{ $total_productos }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-tags text-purple-600"></i>
                        <span class="text-sm text-gray-700">Categorías</span>
                    </div>
                    <span class="font-bold text-purple-700">{{ $total_categorias }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-cyan-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-copyright text-cyan-600"></i>
                        <span class="text-sm text-gray-700">Marcas</span>
                    </div>
                    <span class="font-bold text-cyan-700">{{ $total_marcas }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-truck text-green-600"></i>
                        <span class="text-sm text-gray-700">Proveedores</span>
                    </div>
                    <span class="font-bold text-green-700">{{ $total_proveedores }}</span>
                </div>
            </div>
        </div>

        <!-- Stock Bajo -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    Alertas de Stock Bajo
                </h3>
                @if($productos_stock_bajo->count() > 0)
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $productos_stock_bajo->count() }} productos
                </span>
                @endif
            </div>

            @if($productos_stock_bajo->count() > 0)
            <div class="space-y-2">
                @foreach($productos_stock_bajo as $producto)
                <div class="flex items-center justify-between p-4 bg-red-50 border-l-4 border-red-500 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-4">
                        @if($producto->image)
                        <img src="{{ Storage::url($producto->image) }}" class="w-12 h-12 rounded-lg object-cover">
                        @else
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $producto->name }}</p>
                            <p class="text-sm text-gray-600">SKU: {{ $producto->sku }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Stock actual</p>
                        <p class="text-2xl font-bold text-red-600">{{ $producto->stock }}</p>
                        <p class="text-xs text-gray-500">Mín: {{ $producto->stock_minimo }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-check-circle text-5xl mb-3 text-green-400 opacity-50"></i>
                <p class="text-sm text-green-600 font-medium">¡Todo el stock está bien!</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Top Clientes & Accesos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Clientes -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                <i class="fas fa-users text-primary-600 mr-2"></i>
                Mejores Clientes
            </h3>

            <div x-data="{ tab: 'pos' }">
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-4">
                    <button @click="tab = 'pos'" :class="{ 'bg-white shadow text-gray-900': tab === 'pos', 'text-gray-500 hover:text-gray-700': tab !== 'pos' }" class="flex-1 py-1.5 px-3 rounded-md text-sm font-medium transition-all">
                        <i class="fas fa-store mr-1"></i> Tienda Física
                    </button>
                    <button @click="tab = 'web'" :class="{ 'bg-white shadow text-gray-900': tab === 'web', 'text-gray-500 hover:text-gray-700': tab !== 'web' }" class="flex-1 py-1.5 px-3 rounded-md text-sm font-medium transition-all">
                        <i class="fas fa-globe mr-1"></i> Tienda Online
                    </button>
                </div>

                <!-- POS -->
                <div x-show="tab === 'pos'" class="space-y-3">
                    @if(count($top_clientes['pos']) > 0)
                    @foreach($top_clientes['pos'] as $index => $cliente)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs">
                                {{ $cliente->customer ? $cliente->customer->initials() : 'C' }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $cliente->customer->nombre ?? 'Cliente #' . $cliente->customer_id }}</p>
                                <p class="text-xs text-gray-500">{{ $cliente->total_sales }} compras</p>
                            </div>
                        </div>
                        <span class="font-bold text-gray-900 text-sm">Q{{ number_format($cliente->total_spent, 2) }}</span>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center text-gray-500 text-sm py-4">Sin datos aún.</p>
                    @endif
                </div>

                <!-- Web -->
                <div x-show="tab === 'web'" class="space-y-3" style="display: none;">
                    @if(count($top_clientes['web']) > 0)
                    @foreach($top_clientes['web'] as $index => $cliente)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($cliente->user->name ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $cliente->user->name ?? 'Usuario #' . $cliente->user_id }}</p>
                                <p class="text-xs text-gray-500">{{ $cliente->total_sales }} pedidos</p>
                            </div>
                        </div>
                        <span class="font-bold text-gray-900 text-sm">Q{{ number_format($cliente->total_spent, 2) }}</span>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center text-gray-500 text-sm py-4">Sin datos aún.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-white mb-4">
                <i class="fas fa-bolt mr-2"></i>
                Accesos Rápidos
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <a href="{{ route('admin.pos.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-cash-register text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Nueva Venta</p>
                </a>

                <a href="{{ route('admin.products.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-plus-circle text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Nuevo Producto</p>
                </a>

                <a href="{{ route('admin.customers.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-user-plus text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Nuevo Cliente</p>
                </a>

                <a href="{{ route('admin.cash-report') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-cash-register text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Reporte Caja</p>
                </a>

                <a href="{{ route('admin.sales.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-history text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Ver Ventas</p>
                </a>

                <a href="{{ route('admin.stock-control.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-lg p-4 text-center transition-all transform hover:scale-105">
                    <i class="fas fa-boxes text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Control Stock</p>
                </a>
            </div>
        </div>

    </div>
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
    <script>
        $wire.on('chartsReady', () => {
            // Gráfica de Ventas Semana
            const ctxVentas = document.getElementById('ventasSemanaChart');
            new Chart(ctxVentas, {
                type: 'line',
                data: {
                    labels: @json($labels_semana),
                    datasets: [{
                        label: 'Ventas (Q)',
                        data: @json($ventas_semana),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgb(99, 102, 241)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return 'Q' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Q' + value;
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Gráfica de Métodos de Pago
            const ctxPagos = document.getElementById('metodosPagoChart');
            const totalVentas = {
                {
                    $ventas_efectivo + $ventas_tarjeta + $ventas_transferencia
                }
            };

            if (totalVentas > 0) {
                new Chart(ctxPagos, {
                    type: 'doughnut',
                    data: {
                        labels: ['Efectivo', 'Tarjeta', 'Transferencia'],
                        datasets: [{
                            data: @json([
                                $ventas_efectivo,
                                $ventas_tarjeta,
                                $ventas_transferencia
                            ]),
                            backgroundColor: [
                                'rgb(34, 197, 94)',
                                'rgb(59, 130, 246)',
                                'rgb(249, 115, 22)'
                            ],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return context.label + ': Q' + value.toFixed(2) + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                ctxPagos.parentElement.innerHTML = '<div class="text-center text-gray-400 py-12"><i class="fas fa-chart-pie text-5xl mb-3 opacity-20"></i><p class="text-sm">No hay ventas hoy</p></div>';
            }
        });

        // Disparar evento cuando el componente esté listo
        setTimeout(() => $wire.dispatch('chartsReady'), 100);
    </script>
    @endscript