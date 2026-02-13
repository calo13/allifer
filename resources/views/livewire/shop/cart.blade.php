<div>
    <div x-data="{ show: @entangle('showCheckout') }">
        <!-- Overlay -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="show = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60]" style="display: none;">
        </div>

        <!-- Panel del carrito -->
        <div id="cartPanel" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-2xl z-[70] flex flex-col"
            style="display: none;">

            <!-- Header -->
            <div class="bg-white border-b border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <button @click="show = false"
                        class="flex items-center text-pink-600 hover:text-pink-800 font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Seguir Comprando
                    </button>
                    <button @click="show = false"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-shopping-cart mr-2 text-pink-600"></i>
                    Tu Carrito
                    @if (count($cart) > 0)
                    <span class="ml-2 bg-pink-100 text-pink-600 text-sm font-medium px-2 py-0.5 rounded-full">
                        {{ collect($cart)->sum('quantity') }}
                    </span>
                    @endif
                </h2>
            </div>

            <!-- Contenido scrolleable -->
            <div class="flex-1 overflow-y-auto p-4">
                @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ session('error') }}
                </div>
                @endif

                @if (count($cart) > 0)
                <!-- Items del carrito -->
                <div class="space-y-3 mb-6">
                    @foreach ($cart as $index => $item)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                        @if (isset($item['image']) && $item['image'])
                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}"
                            class="w-16 h-16 object-cover rounded-lg">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm text-gray-900 truncate">{{ $item['name'] }}</h4>
                            @if (!empty($item['variant_text']))
                            <p class="text-xs text-pink-600">{{ $item['variant_text'] }}</p>
                            @endif
                            <p class="text-sm text-pink-600 font-bold">Q{{ number_format($item['precio'], 2) }}</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                    class="w-7 h-7 bg-gray-200 rounded-lg hover:bg-gray-300 flex items-center justify-center transition-colors">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="text-sm font-semibold w-8 text-center">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                    class="w-7 h-7 bg-gray-200 rounded-lg hover:bg-gray-300 flex items-center justify-center transition-colors">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <button wire:click="removeFromCart({{ $index }})"
                            class="w-8 h-8 flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                    @endforeach
                </div>

                <!-- Resumen -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">Q{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">IVA (12%):</span>
                        <span class="font-medium">Q{{ number_format($iva, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2 mt-2">
                        <span>Total:</span>
                        <span class="text-pink-600">Q{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Formulario de checkout -->
                <form wire:submit="checkout" class="space-y-4">

                    {{-- Usuario logueado: mostrar info --}}
                    @auth
                    <div class="bg-pink-50 border border-pink-200 rounded-xl p-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-600 flex items-center justify-center overflow-hidden">
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                <span class="text-white font-bold text-sm">{{ auth()->user()->initials() }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                    </div>

                    {{-- Teléfono editable --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-phone text-pink-600 mr-1"></i> Teléfono *
                        </label>
                        <input type="tel" wire:model="telefono"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="Ej: 5555-1234" required>
                        @error('telefono')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    @else
                    {{-- Usuario invitado: pedir todos los datos --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre Completo *
                        </label>
                        <input type="text" wire:model="nombre"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="Tu nombre completo" required>
                        @error('nombre')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Teléfono *
                        </label>
                        <input type="tel" wire:model="telefono"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="Ej: 5555-1234" required>
                        @error('telefono')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email (opcional)
                        </label>
                        <input type="email" wire:model="email"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="tucorreo@ejemplo.com">
                        @error('email')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Invitar a registrarse --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-user-plus mr-1"></i>
                            <a href="{{ route('register') }}" class="font-semibold underline">Crea una cuenta</a>
                            para guardar tus direcciones y ver tu historial de pedidos.
                        </p>
                    </div>
                    @endauth

                    {{-- Tipo de entrega --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Entrega *
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" wire:click="$set('tipo_entrega', 'domicilio')"
                                class="p-3 border-2 rounded-xl transition-all text-center {{ $tipo_entrega === 'domicilio' ? 'border-pink-600 bg-pink-50 text-pink-700' : 'border-gray-200 hover:border-gray-300' }}">
                                <i class="fas fa-home text-xl mb-1"></i>
                                <p class="font-medium text-xs">Envío a Domicilio</p>
                            </button>

                            <button type="button" wire:click="$set('tipo_entrega', 'recoger')"
                                class="p-3 border-2 rounded-xl transition-all text-center {{ $tipo_entrega === 'recoger' ? 'border-pink-600 bg-pink-50 text-pink-700' : 'border-gray-200 hover:border-gray-300' }}">
                                <i class="fas fa-store text-xl mb-1"></i>
                                <p class="font-medium text-xs">Recoger en Tienda</p>
                            </button>
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div x-show="$wire.tipo_entrega === 'domicilio'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-pink-600 mr-1"></i> Dirección de Entrega *
                        </label>

                        @auth
                        {{-- Usuario logueado: selector de direcciones --}}
                        @if($userAddresses->count() > 0 && !$showNewAddressForm)
                        <div class="space-y-2 mb-3">
                            @foreach($userAddresses as $address)
                            <div wire:click="selectAddress({{ $address->id }})"
                                class="p-3 border-2 rounded-xl cursor-pointer transition-all {{ $selectedAddressId == $address->id ? 'border-pink-600 bg-pink-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold text-pink-600 bg-pink-100 px-2 py-0.5 rounded-full">
                                            {{ $address->alias }}
                                        </span>
                                        @if($address->is_default)
                                        <span class="text-xs text-green-600 ml-1">
                                            <i class="fas fa-star"></i>
                                        </span>
                                        @endif
                                    </div>
                                    @if($selectedAddressId == $address->id)
                                    <i class="fas fa-check-circle text-pink-600"></i>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 mt-1">{{ $address->full_address }}</p>
                                @if($address->referencia)
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>{{ $address->referencia }}
                                </p>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <button type="button" wire:click="showNewAddress"
                            class="w-full p-2 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-pink-400 hover:text-pink-600 transition-all text-sm">
                            <i class="fas fa-plus mr-1"></i> Agregar nueva dirección
                        </button>
                        @endif

                        {{-- Formulario de nueva dirección --}}
                        @if($showNewAddressForm || $userAddresses->count() == 0)
                        <div class="space-y-3 p-3 bg-gray-50 rounded-xl">
                            @if($userAddresses->count() > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Nueva dirección</span>
                                <button type="button" wire:click="cancelNewAddress" class="text-xs text-gray-500 hover:text-gray-700">
                                    Cancelar
                                </button>
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Alias</label>
                                <select wire:model="newAddressAlias" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option value="Casa">🏠 Casa</option>
                                    <option value="Trabajo">🏢 Trabajo</option>
                                    <option value="Oficina">💼 Oficina</option>
                                    <option value="Otro">📍 Otro</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Dirección completa *</label>
                                <textarea wire:model="direccion" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="Calle, número, colonia..." required></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Zona</label>
                                    <input type="text" wire:model="newAddressZona"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                        placeholder="Ej: 10">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Referencia</label>
                                    <input type="text" wire:model="newAddressReferencia"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                        placeholder="Ej: Casa azul">
                                </div>
                            </div>

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" wire:model="saveNewAddress" class="rounded border-gray-300 text-pink-600">
                                <span class="text-gray-600">Guardar para futuras compras</span>
                            </label>
                        </div>
                        @endif
                        @else
                        {{-- Usuario invitado: solo textarea --}}
                        <textarea wire:model="direccion" rows="2"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="Zona, colonia, calle, número de casa..." required></textarea>
                        @endauth

                        @error('direccion')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            El costo de envío será confirmado por el vendedor.
                        </p>
                    </div>

                    {{-- Recoger en tienda --}}
                    <div x-show="$wire.tipo_entrega === 'recoger'" x-cloak>
                        <div class="bg-green-50 border border-green-200 rounded-xl p-3">
                            <p class="text-sm text-green-800">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <strong>Dirección de la tienda:</strong><br>
                                13 calle A 2-80 zona 3 ciudad capital<br>
                                <span class="text-xs">Lun - Sáb: 8:00 AM - 6:00 PM</span>
                            </p>
                        </div>
                    </div>

                    {{-- Notas --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notas (opcional)
                        </label>
                        <textarea wire:model="notas" rows="2"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm"
                            placeholder="Instrucciones especiales..."></textarea>
                    </div>

                    {{-- Método de pago --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-money-bill-wave mr-1"></i>
                            Pago: <strong>Efectivo contra entrega</strong>
                        </p>
                    </div>

                    {{-- Botón confirmar --}}
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white py-3 rounded-xl hover:from-pink-700 hover:to-rose-700 font-bold transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-check-circle mr-2"></i>
                        Confirmar Pedido
                    </button>
                </form>
                @else
                <!-- Carrito vacío -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-300 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg mb-2">Tu carrito está vacío</p>
                    <p class="text-gray-400 text-sm mb-6">Agrega productos para comenzar</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('add-to-cart', (event) => {
        $wire.addToCart(
            event.productId,
            event.quantity || 1,
            event.variants || {},
            event.finalPrice || null
        );
    });
</script>
@endscript