<x-layouts.public>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4">

            <!-- Mensaje de éxito -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <!-- Ícono de éxito -->
                <div class="mb-6">
                    <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    ¡Pedido Confirmado!
                </h1>

                <p class="text-lg text-gray-600 mb-6">
                    Tu pedido ha sido registrado exitosamente. Te contactaremos pronto para confirmar la entrega.
                </p>

                <!-- Información del pedido -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-gray-500">Número de Pedido</p>
                            <p class="text-lg font-bold text-indigo-600">{{ $order->folio }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-lg font-bold text-gray-900">Q{{ number_format($order->total, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo de Entrega</p>
                            <p class="text-base font-semibold text-gray-700">
                                @if ($order->tipo_entrega === 'domicilio')
                                <i class="fas fa-home mr-1 text-indigo-600"></i> Envío a Domicilio
                                @else
                                <i class="fas fa-store mr-1 text-green-600"></i> Recoger en Tienda
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estado</p>
                            <span
                                class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                Pendiente
                            </span>
                        </div>
                    </div>

                    @if ($order->tipo_entrega === 'domicilio')
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Dirección de Entrega:</p>
                        <p class="text-base text-gray-900">{{ $order->direccion_entrega }}</p>
                    </div>
                    @else
                    <div class="mt-4 pt-4 border-t border-gray-200 bg-green-50 rounded-lg p-3">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <strong>Recoger en:</strong><br>
                            Zona 10, Guatemala City<br>
                            <small>Horario: Lunes a Sábado, 9:00 AM - 6:00 PM</small>
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 text-left">Productos</h3>
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 text-left">
                                <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-bold text-indigo-600">Q{{ number_format($item->subtotal, 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Información de contacto -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Hemos registrado tu pedido. Nos pondremos en contacto contigo al
                        <strong>{{ $order->telefono_cliente }}</strong> para
                        @if ($order->tipo_entrega === 'domicilio')
                        coordinar la entrega.
                        @else
                        confirmar cuando puedes recoger tu pedido en la tienda.
                        @endif
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('catalogo') }}"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Seguir Comprando
                    </a>

                    <a href="https://wa.me/50249075678?text=Hola,%20quiero%20consultar%20sobre%20mi%20pedido%20{{ $order->folio }}"
                        target="_blank"
                        class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 font-semibold">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Contactar por WhatsApp
                    </a>
                    </a>
                </div>

                <!-- Botón de Seguimiento -->
                <div class="mt-4 text-center">
                    <a href="{{ route('shop.order-tracking', ['orderNumber' => $order->order_number]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-search-location mr-1"></i> Rastrear mi pedido
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>