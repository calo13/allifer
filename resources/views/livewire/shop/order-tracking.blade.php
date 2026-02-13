<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

    @if(!$order)
    <!-- VISTA INICIAL: BUSCADOR CENTRADO -->
    <div class="flex flex-col justify-center items-center min-h-[60vh]">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="mx-auto h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg mb-6 transform hover:scale-105 transition-transform duration-300">
                <i class="fas fa-search-location text-2xl text-white"></i>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-gray-900 tracking-tight">
                Rastrea tu Pedido
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ingresa tu número de orden para ver el estado actual
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-50 rounded-full blur-3xl opacity-50"></div>

                <form wire:submit.prevent="trackOrder" class="space-y-6 relative z-10">
                    <div>
                        <label for="orderNumber" class="block text-sm font-medium text-gray-700">
                            Número de Orden <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                            <input type="text" wire:model="orderNumber" id="orderNumber"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-3"
                                placeholder="Ej: PED-000504">
                        </div>
                        @error('orderNumber')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="emailOrPhone" class="block text-sm font-medium text-gray-700">
                            Correo o Teléfono <span class="text-gray-400 text-xs font-normal">(Opcional)</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-shield text-gray-400"></i>
                            </div>
                            <input type="text" wire:model="emailOrPhone" id="emailOrPhone"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-3"
                                placeholder="Para mayor seguridad">
                        </div>
                        @error('emailOrPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:-translate-y-0.5">
                            <span wire:loading.remove>
                                <i class="fas fa-search mr-2"></i> Buscar Pedido
                            </span>
                            <span wire:loading>
                                <i class="fas fa-circle-notch fa-spin mr-2"></i> Buscando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <!-- VISTA DE RESULTADOS: GRID LAYOUT -->
    <div class="max-w-7xl mx-auto animate-fade-in-up">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- COLUMNA IZQUIERDA: BUSCADOR COMPACTO (SIDEBAR) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-search text-indigo-500"></i>
                        <h3 class="text-lg font-bold text-gray-900">Rastrear otro</h3>
                    </div>

                    <form wire:submit.prevent="trackOrder" class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Orden / Folio</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-300"></i>
                                </div>
                                <input type="text" wire:model="orderNumber"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="#AD-0004">
                            </div>
                            @error('orderNumber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 focus:outline-none transition-colors">
                            <span wire:loading.remove>Buscar</span>
                            <span wire:loading><i class="fas fa-circle-notch fa-spin"></i></span>
                        </button>
                    </form>
                </div>

                <!-- Card de Ayuda -->
                <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-headset text-indigo-600 mt-1"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-indigo-900">¿Necesitas ayuda?</p>
                            <p class="text-xs text-indigo-700 mt-1">Si tienes dudas sobre tu entrega, contáctanos.</p>
                            <a href="#" class="inline-block mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 underline">
                                Ir a Contacto
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: DETALLES DEL PEDIDO (MAIN) -->
            <div class="lg:col-span-3">
                <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">

                    <!-- Encabezado del Pedido -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xl font-bold text-gray-900">#{{ $order->order_number }}</h3>
                                <span class="text-sm text-gray-500">| {{ $order->created_at->format('d M, Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Cliente: <span class="font-medium text-gray-900">{{ $order->nombre_cliente }}</span>
                            </p>
                        </div>

                        <div class="flex flex-col items-end">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 border border-{{ $order->status_color }}-200">
                                {{ $order->status_emoji }} {{ strtoupper($order->status_name) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Timeline Horizontal -->
                        <div class="mb-10 px-2 sm:px-4">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t-2 border-gray-100"></div>
                                </div>
                                <div class="relative flex justify-between">
                                    @php
                                    $steps = [
                                    ['status' => 'pendiente', 'label' => 'Confirmado', 'icon' => 'fa-clipboard-check'],
                                    ['status' => 'en_proceso', 'label' => 'Preparando', 'icon' => 'fa-box-open'],
                                    ['status' => 'enviado', 'label' => 'En Camino', 'icon' => 'fa-shipping-fast'],
                                    ['status' => 'entregado', 'label' => 'Entregado', 'icon' => 'fa-home'],
                                    ];
                                    $currentFound = false;
                                    $orderStatus = $order->estado == 'aprobado' ? 'pendiente' : $order->estado;
                                    @endphp

                                    @foreach($steps as $step)
                                    @php
                                    $isCompleted = false;
                                    $isCurrent = false;
                                    if ($orderStatus == 'cancelado') {
                                    $isCompleted = false; $isCurrent = false;
                                    } elseif ($orderStatus == $step['status']) {
                                    $isCurrent = true; $currentFound = true; $isCompleted = true;
                                    } elseif (!$currentFound) {
                                    $isCompleted = true;
                                    }
                                    @endphp
                                    <div class="flex flex-col items-center group relative cursor-default">
                                        <div class="relative flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full {{ $isCompleted ? 'bg-indigo-600 shadow-md' : 'bg-white border-2 border-gray-200' }} {{ $isCurrent ? 'ring-4 ring-indigo-100 scale-110' : '' }} z-10 transition-all duration-300">
                                            <i class="fas {{ $step['icon'] }} {{ $isCompleted ? 'text-white' : 'text-gray-400' }} text-sm sm:text-base"></i>
                                        </div>
                                        <div class="mt-3 text-xs sm:text-sm font-medium {{ $isCompleted ? 'text-indigo-600' : 'text-gray-400' }}">
                                            {{ $step['label'] }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                            <!-- Historial -->
                            <div>
                                <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-history text-indigo-500 mr-2"></i> Actividad Reciente
                                </h4>
                                <div class="flow-root pl-2">
                                    <ul role="list" class="-mb-8">
                                        @foreach($order->status_history as $history)
                                        <li>
                                            <div class="relative pb-6">
                                                @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                                {{ $history['to'] == 'entregado' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                                            <i class="fas fa-circle text-[8px]"></i>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-900 font-medium">
                                                                {{ ucfirst($history['to']) }}
                                                            </p>
                                                            @if(isset($history['notes']) && $history['notes'])
                                                            <p class="text-xs text-gray-500">{{ $history['notes'] }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-right text-xs text-gray-400">
                                                            {{ \Carbon\Carbon::parse($history['changed_at'])->format('d M, h:i A') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Resumen y Entrega -->
                            <div class="space-y-6">
                                <!-- Card Dirección -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i> Entrega en:
                                    </h5>
                                    <p class="text-sm text-gray-900">{{ $order->direccion_entrega }}</p>
                                    @if($order->telefono_cliente)
                                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i> {{ $order->telefono_cliente }}</p>
                                    @endif
                                </div>

                                <!-- Productos -->
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3">Productos</h5>
                                    <ul class="divide-y divide-gray-100">
                                        @foreach($order->items as $item)
                                        <li class="py-2 flex justify-between items-center text-sm">
                                            <div class="flex items-center gap-3">
                                                <span class="text-gray-400 font-medium">{{ $item->quantity }}x</span>
                                                <span class="text-gray-900">{{ $item->product_name }}</span>
                                            </div>
                                            <span class="font-medium text-gray-900">Q{{ number_format($item->subtotal, 2) }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="bg-gray-50 p-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600">Subtotal</span>
                                        <span class="text-sm font-medium text-gray-900">Q{{ number_format($order->subtotal, 2) }}</span>
                                    </div>

                                    @if($order->descuento > 0)
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600">Descuento</span>
                                        <span class="text-sm font-medium text-red-600">-Q{{ number_format($order->descuento, 2) }}</span>
                                    </div>
                                    @endif

                                    @if($order->iva > 0)
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600">IVA (12%)</span>
                                        <span class="text-sm font-medium text-gray-900">Q{{ number_format($order->iva, 2) }}</span>
                                    </div>
                                    @endif

                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600">Envío</span>
                                        @if($order->shipping_cost > 0)
                                        <span class="text-sm font-medium text-gray-900">Q{{ number_format($order->shipping_cost, 2) }}</span>
                                        @else
                                        <span class="text-sm font-medium text-green-600">Gratis</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                        <span class="text-base font-bold text-gray-900">Total Pagado</span>
                                        <span class="text-xl font-bold text-indigo-600">Q{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón Nueva Búsqueda -->
                        <div class="mt-6">
                            <button wire:click="$set('order', null)" class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Rastrear otro pedido
                            </button>
                        </div>

                        @if($order->whatsapp_link)
                        <div class="mt-8 text-center border-t border-gray-100 pt-6">
                            <a href="{{ $order->whatsapp_link }}" target="_blank" class="inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-full text-green-700 bg-green-100 hover:bg-green-200 transition-colors">
                                <i class="fab fa-whatsapp mr-2 text-lg"></i> Recibir actualizaciones por WhatsApp
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>
    @endif

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out forwards;
        }
    </style>
</div>