<div x-data="{
    statusModal: false,
    selectedOrderId: null,
    selectedOrderStatus: null,
    selectedOrderType: null
}">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-shopping-cart text-primary-600 mr-3"></i>
                    Pedidos Online
                </h1>
                <p class="mt-2 text-sm text-gray-600">Gestiona los pedidos de tu tienda online</p>
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
                <button wire:click="$refresh"
                    class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
    <div
        class="mb-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Estadísticas COMPACTAS -->
    <div class="grid grid-cols-3 md:grid-cols-6 gap-3 mb-5">
        <div
            class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-lg shadow-sm border border-yellow-200 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">🟡</div>
                <div class="text-right">
                    <div class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Pendientes</div>
                </div>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-sm border border-green-200 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">✅</div>
                <div class="text-right">
                    <div class="text-xl font-bold text-gray-900">{{ $stats['approved'] }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Aprobados</div>
                </div>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg shadow-sm border border-blue-200 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">🔵</div>
                <div class="text-right">
                    <div class="text-xl font-bold text-gray-900">{{ $stats['processing'] }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Proceso</div>
                </div>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-primary-50 to-purple-50 rounded-lg shadow-sm border border-primary-200 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">🚚</div>
                <div class="text-right">
                    <div class="text-xl font-bold text-gray-900">{{ $stats['shipped'] }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Enviados</div>
                </div>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-lg shadow-sm border border-gray-200 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">🟢</div>
                <div class="text-right">
                    <div class="text-xl font-bold text-gray-900">{{ $stats['delivered_today'] }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Hoy</div>
                </div>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-lg shadow-sm border border-emerald-300 p-3 hover:shadow-md transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="text-2xl">💰</div>
                <div class="text-right">
                    <div class="text-lg font-bold text-gray-900">Q{{ number_format($stats['total_today'], 2) }}</div>
                    <div class="text-[10px] text-gray-600 uppercase tracking-wide">Ventas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Switcher & Filters -->
    <div class="mb-5 flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Search & Filters -->
        <div class="flex-1 w-full bg-white rounded-xl shadow-sm border border-gray-200 p-2">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por número, cliente, teléfono..."
                        class="w-full pl-10 pr-4 py-2 text-sm border-none focus:ring-0 rounded-lg">
                </div>
                <div class="w-px bg-gray-200 hidden md:block"></div>
                <div class="md:w-48 relative">
                    <select wire:model.live="statusFilter"
                        class="w-full pl-2 pr-8 py-2 text-sm border-none focus:ring-0 bg-transparent cursor-pointer">
                        <option value="all">📋 Todos</option>
                        <option value="pendiente">🟡 Pendiente</option>
                        <option value="aprobado">✅ Aprobado</option>
                        <option value="en_proceso">🔵 En Proceso</option>
                        <option value="enviado">🚚 Enviado</option>
                        <option value="entregado">🟢 Entregado</option>
                        <option value="cancelado">🔴 Cancelado</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- View Toggle -->
        <div class="flex bg-white rounded-xl shadow-sm border border-gray-200 p-1">
            <button wire:click="$set('viewMode', 'list')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'list' ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-list mr-2"></i>Lista
            </button>
            <button wire:click="$set('viewMode', 'board')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $viewMode === 'board' ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-columns mr-2"></i>Tablero
            </button>
        </div>
    </div>

    <!-- KANBAN BOARD -->
    <div x-show="$wire.viewMode === 'board'" class="overflow-x-auto pb-4" style="display: none;">
        <div class="flex space-x-4 min-w-max">
            @php
            $columns = [
            'pendiente' => ['label' => 'Pendientes', 'color' => 'yellow', 'icon' => '🟡'],
            'aprobado' => ['label' => 'Aprobados', 'color' => 'green', 'icon' => '✅'],
            'en_proceso' => ['label' => 'En Proceso', 'color' => 'blue', 'icon' => '🔵'],
            'enviado' => ['label' => 'Enviados', 'color' => 'indigo', 'icon' => '🚚'],
            'entregado' => ['label' => 'Entregados', 'color' => 'gray', 'icon' => '🟢'],
            ];
            @endphp

            @foreach($columns as $status => $config)
            <div class="w-60 flex-shrink-0 flex flex-col bg-gray-50 rounded-xl border border-gray-200 max-h-[700px]">
                <!-- Column Header -->
                <div class="p-2 border-b border-gray-200 bg-white rounded-t-xl sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-base">{{ $config['icon'] }}</span>
                            <h3 class="font-semibold text-gray-700 text-sm">{{ $config['label'] }}</h3>
                        </div>
                        <span class="bg-gray-100 text-gray-600 text-[10px] px-1.5 py-0.5 rounded-full font-medium">
                            {{ $orders->where('estado', $status)->count() }}
                        </span>
                    </div>
                </div>

                <!-- Cards Container -->
                <div class="p-2 flex-1 overflow-y-auto space-y-2 custom-scrollbar">
                    @forelse($orders->where('estado', $status) as $order)
                    <div wire:key="board-order-{{ $order->id }}" class="bg-white p-2.5 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer group relative"
                        wire:click="viewOrder({{ $order->id }})">

                        <div class="flex justify-between items-start mb-1.5">
                            <div class="overflow-hidden">
                                <span class="text-[10px] font-bold text-primary-600 block">#{{ $order->order_number }}</span>
                                <p class="text-xs font-medium text-gray-900 truncate w-32" title="{{ $order->nombre_cliente }}">{{ $order->nombre_cliente }}</p>
                            </div>
                            <span class="text-[10px] text-gray-400 whitespace-nowrap ml-1">{{ $order->created_at->diffForHumans(null, true, true) }}</span>
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center space-x-1">
                                @if($order->tipo_entrega === 'domicilio')
                                <span class="px-1 py-0.5 rounded text-[9px] bg-blue-50 text-blue-600 border border-blue-100"><i class="fas fa-truck"></i></span>
                                @else
                                <span class="px-1 py-0.5 rounded text-[9px] bg-purple-50 text-purple-600 border border-purple-100"><i class="fas fa-store"></i></span>
                                @endif

                                <span class="text-[10px] text-gray-500">{{ count($order->items) }} <span class="hidden sm:inline">items</span></span>
                            </div>
                            <span class="font-bold text-gray-900 text-xs">Q{{ number_format($order->total, 2) }}</span>
                        </div>

                        <!-- Quick Actions (Hover) -->
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-1">
                            <button wire:click.stop="selectedOrderId = {{ $order->id }}; selectedOrderStatus = '{{ $order->estado }}'; selectedOrderType = '{{ $order->tipo_entrega }}'; statusModal = true"
                                class="p-1 bg-gray-100 hover:bg-gray-200 rounded text-gray-600">
                                <i class="fas fa-edit text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    @if($orders->where('estado', $status)->isEmpty())
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                        <p class="text-xs">Sin pedidos</p>
                    </div>
                    @endif
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tabla de Pedidos (LIST VIEW) -->
    <div x-show="$wire.viewMode === 'list'" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-hashtag mr-1"></i>Número</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-user mr-1"></i>Cliente</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-phone mr-1"></i>Contacto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-truck mr-1"></i>Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-dollar-sign mr-1"></i>Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-flag mr-1"></i>Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-calendar mr-1"></i>Fecha</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider"><i
                                class="fas fa-cog mr-1"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr
                        class="hover:bg-gradient-to-r hover:from-primary-50 hover:to-purple-50 transition-all duration-200">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-base font-bold text-primary-600">#{{ $order->order_number }}</span>
                                <span class="text-xs text-gray-500">{{ $order->folio }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $order->nombre_cliente ?: 'Invitado' }}
                            </div>
                            @if ($order->tipo === 'invitado')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 mt-1">
                                <i class="fas fa-user-secret mr-1"></i>Invitado
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if ($order->telefono_cliente)
                            <div class="text-xs text-gray-600 flex items-center mb-1"><i
                                    class="fas fa-phone text-green-500 mr-1"></i>{{ $order->telefono_cliente }}
                            </div>
                            @endif
                            @if ($order->email_cliente)
                            <div class="text-xs text-gray-600 flex items-center"><i
                                    class="fas fa-envelope text-blue-500 mr-1"></i>{{ Str::limit($order->email_cliente, 20) }}
                            </div>
                            @endif
                            @if (!$order->telefono_cliente && !$order->email_cliente)
                            <span class="text-xs text-gray-400 italic">Sin contacto</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($order->tipo_entrega === 'domicilio')
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800"><i
                                    class="fas fa-truck mr-1"></i>Envío</span>
                            @else
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800"><i
                                    class="fas fa-store mr-1"></i>Recoger</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-bold text-green-600">Q{{ number_format($order->total, 2) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <button
                                @click="selectedOrderId = {{ $order->id }}; selectedOrderStatus = '{{ $order->estado }}'; selectedOrderType = '{{ $order->tipo_entrega }}'; statusModal = true"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm hover:shadow-md transition-all cursor-pointer
                                    @if ($order->estado === 'pendiente') bg-gradient-to-r from-yellow-400 to-amber-500 text-white hover:from-yellow-500 hover:to-amber-600
                                    @elseif($order->estado === 'aprobado') bg-gradient-to-r from-green-400 to-emerald-500 text-white hover:from-green-500 hover:to-emerald-600
                                    @elseif($order->estado === 'en_proceso') bg-gradient-to-r from-blue-400 to-cyan-500 text-white hover:from-blue-500 hover:to-cyan-600
                                    @elseif($order->estado === 'enviado') bg-gradient-to-r from-primary-400 to-purple-500 text-white hover:from-primary-500 hover:to-purple-600
                                    @elseif($order->estado === 'entregado') bg-gradient-to-r from-gray-600 to-gray-700 text-white hover:from-gray-700 hover:to-gray-800
                                    @elseif($order->estado === 'cancelado') bg-gradient-to-r from-red-400 to-rose-500 text-white hover:from-red-500 hover:to-rose-600 
                                    @else bg-gradient-to-r from-gray-400 to-gray-500 text-white @endif">
                                {{ $order->status_emoji }} {{ $order->status_name }}
                                <i class="fas fa-edit ml-2 text-[10px]"></i>
                            </button>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-xs text-gray-900 font-medium">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-1.5">
                                <a wire:click="viewOrder({{ $order->id }})"
                                    class="inline-flex items-center px-2.5 py-1.5 bg-gradient-to-r from-blue-500 to-primary-600 hover:from-blue-600 hover:to-primary-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all"><i
                                        class="fas fa-eye"></i></a>
                                @if ($order->telefono_cliente)
                                <a href="{{ $order->whatsapp_link }}" target="_blank"
                                    class="inline-flex items-center px-2.5 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all"><i
                                        class="fab fa-whatsapp"></i></a>
                                @endif
                                @if ($order->email_cliente)
                                <a wire:click="sendEmail({{ $order->id }})" style="cursor: pointer;" class="inline-flex items-center px-2.5 py-1.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all"><i
                                        class="fas fa-envelope"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                                </div>
                                <p class="text-base font-medium text-gray-900 mb-1">No hay pedidos para mostrar</p>
                                <p class="text-sm text-gray-500 mb-3">Los pedidos aparecerán aquí cuando los
                                    clientes realicen compras</p>
                                @if ($search || $statusFilter !== 'all')
                                <button wire:click="clearFilters"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-all"><i
                                        class="fas fa-times mr-2"></i>Limpiar filtros</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL con fondo suave -->
    <div x-show="statusModal" @keydown.escape.window="statusModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div @click="statusModal = false" class="absolute inset-0 bg-black bg-opacity-20 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full" @click.stop>
            <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center"><i
                            class="fas fa-exchange-alt mr-2"></i>Cambiar Estado del Pedido</h3>
                    <button @click="statusModal = false" type="button"
                        class="text-white hover:text-gray-200 transition-colors"><i
                            class="fas fa-times text-xl"></i></button>
                </div>
            </div>
            <div class="px-6 py-5">
                <p class="text-sm text-gray-600 mb-4">Selecciona el nuevo estado para este pedido:</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button"
                        @click="if(selectedOrderStatus !== 'pendiente') { $wire.changeStatus(selectedOrderId, 'pendiente'); statusModal = false; }"
                        :disabled="selectedOrderStatus === 'pendiente'"
                        :class="selectedOrderStatus === 'pendiente' ? 'opacity-50 cursor-not-allowed' :
                            'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-yellow-300 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <div class="text-3xl mb-2">🟡</div>
                        <span class="text-sm font-semibold text-gray-900">Pendiente</span>
                    </button>

                    <button type="button"
                        @click="if(selectedOrderStatus !== 'aprobado') { $wire.changeStatus(selectedOrderId, 'aprobado'); statusModal = false; }"
                        :disabled="selectedOrderStatus === 'aprobado'"
                        :class="selectedOrderStatus === 'aprobado' ? 'opacity-50 cursor-not-allowed' :
                            'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <div class="text-3xl mb-2">✅</div>
                        <span class="text-sm font-semibold text-gray-900">Aprobado</span>
                    </button>

                    <button type="button"
                        @click="if(selectedOrderStatus !== 'en_proceso') { $wire.changeStatus(selectedOrderId, 'en_proceso'); statusModal = false; }"
                        :disabled="selectedOrderStatus === 'en_proceso'"
                        :class="selectedOrderStatus === 'en_proceso' ? 'opacity-50 cursor-not-allowed' :
                            'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-300 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <div class="text-3xl mb-2">🔵</div>
                        <span class="text-sm font-semibold text-gray-900">En Proceso</span>
                    </button>

                    <button type="button"
                        @click="if(selectedOrderType === 'domicilio' && selectedOrderStatus !== 'enviado') { $wire.changeStatus(selectedOrderId, 'enviado'); statusModal = false; }"
                        :disabled="selectedOrderStatus === 'enviado' || selectedOrderType !== 'domicilio'"
                        :class="(selectedOrderStatus === 'enviado' || selectedOrderType !== 'domicilio') ?
                        'opacity-50 cursor-not-allowed' : 'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-primary-50 to-purple-50 border-2 border-primary-300 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <div class="text-3xl mb-2">🚚</div>
                        <span class="text-sm font-semibold text-gray-900">Enviado</span>
                        <span class="text-[10px] text-gray-500 mt-1" x-show="selectedOrderType !== 'domicilio'">(Solo
                            envíos)</span>
                    </button>

                    <button type="button"
                        @click="if(selectedOrderStatus !== 'entregado') { $wire.changeStatus(selectedOrderId, 'entregado'); statusModal = false; }"
                        :disabled="selectedOrderStatus === 'entregado'"
                        :class="selectedOrderStatus === 'entregado' ? 'opacity-50 cursor-not-allowed' :
                            'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-300 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <div class="text-3xl mb-2">🟢</div>
                        <span class="text-sm font-semibold text-gray-900">Entregado</span>
                    </button>

                    <button type="button"
                        @click="Swal.fire({title:'¿Cancelar pedido?',text:'¿Estás seguro de que deseas cancelar este pedido?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',confirmButtonText:'Sí, cancelar',cancelButtonText:'No, volver'}).then((result)=>{if(result.isConfirmed){$wire.changeStatus(selectedOrderId, 'cancelado');statusModal=false}})"
                        :disabled="selectedOrderStatus === 'cancelado'"
                        :class="selectedOrderStatus === 'cancelado' ? 'opacity-50 cursor-not-allowed' :
                            'hover:scale-105 active:scale-95'"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-300 rounded-xl transition-all shadow-sm hover:shadow-md col-span-2">
                        <div class="text-3xl mb-2">🔴</div>
                        <span class="text-sm font-semibold text-gray-900">Cancelar Pedido</span>
                    </button>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end rounded-b-2xl">
                <button @click="statusModal = false" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <div wire:loading class="fixed top-4 right-4 z-50">
        <div
            class="bg-white rounded-xl px-6 py-4 shadow-2xl border border-primary-200 flex items-center space-x-3 animate-fade-in">
            <div class="w-10 h-10 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin"></div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Procesando...</p>
                <p class="text-xs text-gray-500">Por favor espera</p>
            </div>
        </div>
    </div>
    <!-- Modal Detalle Pedido -->
    <div x-show="$wire.showDetailModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">

        <div @click="$wire.closeDetailModal()" class="absolute inset-0 bg-white/70 backdrop-blur-[2px]"></div>

        @if($selectedOrder)
        <div x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full border border-gray-200"
            @click.stop>

            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 to-purple-500 px-6 py-4 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Pedido #{{ $selectedOrder->order_number }}</h3>
                    <p class="text-primary-100 text-xs">{{ $selectedOrder->created_at->format('d/m/Y h:i A') }}</p>
                </div>
                <button wire:click="closeDetailModal" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6">

                <!-- Cards pequeños para info -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <!-- Cliente -->
                    <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-blue-600 font-medium mb-1">Cliente</p>
                        <p class="font-semibold text-sm">{{ $selectedOrder->nombre_cliente }}</p>
                        <p class="text-xs text-gray-600">{{ $selectedOrder->telefono_cliente }}</p>
                    </div>

                    <!-- Dirección -->
                    <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                        <p class="text-xs text-purple-600 font-medium mb-1">Dirección</p>
                        <p class="text-xs text-gray-700 leading-tight">{{ Str::limit($selectedOrder->direccion_entrega, 40) }}</p>
                    </div>

                    <!-- Método de pago -->
                    <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                        <p class="text-xs text-green-600 font-medium mb-1">Pago</p>
                        <p class="text-sm font-semibold">{{ ucfirst($selectedOrder->metodo_pago) }}</p>
                    </div>
                </div>

                <!-- Productos compactos -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2 font-medium">Productos</p>
                    @foreach($selectedOrder->items as $item)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm">{{ $item->product->name }} <span class="text-gray-500">x{{ $item->quantity }}</span></span>
                        <span class="font-semibold text-sm">Q{{ number_format($item->precio_unitario * $item->quantity, 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Totales -->
                <div class="space-y-1 pt-3 border-t-2 border-gray-200">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal:</span>
                        <span>Q{{ number_format($selectedOrder->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>IVA:</span>
                        <span>Q{{ number_format($selectedOrder->iva, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold">Total:</span>
                        <span class="text-2xl font-bold text-primary-600">Q{{ number_format($selectedOrder->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
</div>