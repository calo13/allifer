<x-layouts.public>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a href="{{ route('cliente.pedidos') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Volver a mis pedidos
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pedido #{{ $order->order_number }}</h1>
                    <p class="text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
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
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Productos --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-gray-900 mb-4">
                    <i class="fas fa-box text-indigo-600 mr-2"></i>Productos
                </h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product_name }}"
                                class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-box text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                            @if($item->variant_text)
                            <p class="text-sm text-indigo-600">{{ $item->variant_text }}</p>
                            @endif
                            <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-bold text-gray-900">Q{{ number_format($item->subtotal, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Resumen y Entrega --}}
            <div class="space-y-6">
                {{-- Total --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-gray-900 mb-4">
                        <i class="fas fa-receipt text-indigo-600 mr-2"></i>Total
                    </h2>
                    <div class="flex justify-between text-xl font-bold">
                        <span>Total</span>
                        <span class="text-indigo-600">Q{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                {{-- Datos de entrega --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-gray-900 mb-4">
                        <i class="fas fa-truck text-indigo-600 mr-2"></i>Entrega
                    </h2>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-500">Tipo:</span> {{ ucfirst($order->tipo_entrega ?? 'Delivery') }}</p>
                        @if($order->direccion_entrega)
                        <p><span class="text-gray-500">Dirección:</span> {{ $order->direccion_entrega }}</p>
                        @endif
                        <p><span class="text-gray-500">Teléfono:</span> {{ $order->telefono_cliente }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>