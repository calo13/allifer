<x-layouts.public>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            <i class="fas fa-shopping-bag text-indigo-600 mr-2"></i>
            Mis Pedidos
        </h1>

        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-gray-900">#{{ $order->order_number }}</span>
                            <span class="text-sm px-2 py-0.5 rounded-full 
                                        @if($order->estado == 'pendiente') bg-yellow-100 text-yellow-700
                                        @elseif($order->estado == 'aprobado') bg-blue-100 text-blue-700
                                        @elseif($order->estado == 'en_proceso') bg-indigo-100 text-indigo-700
                                        @elseif($order->estado == 'enviado') bg-purple-100 text-purple-700
                                        @elseif($order->estado == 'entregado') bg-green-100 text-green-700
                                        @elseif($order->estado == 'cancelado') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                {{ $order->status_emoji }} {{ $order->status_name }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-box mr-1"></i>
                            {{ $order->items->count() }} producto(s)
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-xl font-bold text-indigo-600">Q{{ number_format($order->total, 2) }}</p>
                        <a href="{{ route('cliente.pedido.detalle', $order) }}"
                            class="inline-flex items-center mt-2 text-sm text-indigo-600 hover:text-indigo-800">
                            Ver detalle <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes pedidos aún</h3>
            <p class="text-gray-500 mb-6">¡Explora nuestro catálogo y haz tu primer pedido!</p>
            <a href="{{ route('catalogo') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                <i class="fas fa-store mr-2"></i> Ver Catálogo
            </a>
        </div>
        @endif
    </div>
</x-layouts.public>