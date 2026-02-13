<div wire:poll.10s class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <!-- Bell Icon -->
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
        <i class="fas fa-bell text-xl"></i>

        @if($count > 0)
        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full border-2 border-white shadow-sm">
            {{ $count > 99 ? '99+' : $count }}
        </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 z-50 origin-top-right border border-gray-100"
        style="display: none;">

        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
            <h3 class="text-sm font-semibold text-gray-900">Notificaciones</h3>
            <p class="text-xs text-gray-500 mt-0.5">Pedidos activos pendientes</p>
        </div>

        <div class="max-h-80 overflow-y-auto custom-scrollbar">
            @forelse($orders as $order)
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 group">
                <div class="flex items-start">
                    <div class="flex-shrink-0 pt-1">
                        @if($order->estado === 'pendiente')
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                        @elseif($order->estado === 'aprobado')
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-400"></span>
                        @elseif($order->estado === 'en_proceso')
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                        @else
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-primary-400"></span>
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-primary-600 transition-colors">
                            Orden #{{ $order->order_number }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $order->nombre_cliente }}
                        </p>
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-400">
                                {{ $order->created_at->diffForHumans(null, true, true) }}
                            </p>
                            <span class="text-xs font-semibold text-gray-700">Q{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="px-4 py-8 text-center">
                <i class="fas fa-check-circle text-3xl text-green-100 mb-2"></i>
                <p class="text-sm text-gray-500">¡Todo al día! No hay pedidos pendientes.</p>
            </div>
            @endforelse
        </div>

        <div class="p-2 border-t border-gray-100 bg-gray-50 rounded-b-xl text-center">
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-primary-600 hover:text-primary-500 block py-1">
                Ver todos los pedidos <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>
