<div>
    <div x-data="{ show: @entangle('showCheckout') }">
        <!-- Overlay -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="show = false"
            class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm z-[60]" style="display: none;">
        </div>

        <!-- Panel del carrito -->
        <div id="cartPanel" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-2xl z-[70] flex flex-col border-l border-gray-100"
            style="display: none;">

            <!-- Header -->
            <div class="bg-primary-900 text-white p-4 shadow-lg relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <button @click="show = false"
                            class="flex items-center text-gray-300 hover:text-white font-medium transition-colors text-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Seguir Comprando
                        </button>
                        <button @click="show = false"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-shopping-cart mr-2 text-secondary-500"></i>
                        Tu Carrito
                        @if (count($cart) > 0)
                        <span class="ml-2 bg-secondary-500 text-primary-900 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ collect($cart)->sum('quantity') }}
                        </span>
                        @endif
                    </h2>
                </div>
            </div>

            <!-- Contenido scrolleable -->
            <div class="flex-1 overflow-y-auto p-4 bg-gray-50">
                @if (session('success'))
                <div class="mb-4 p-3 bg-emerald-100 border border-emerald-400 text-emerald-700 rounded-lg text-sm shadow-sm">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm shadow-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ session('error') }}
                </div>
                @endif

                @if (count($cart) > 0)
                <!-- Items del carrito -->
                <div class="space-y-3 mb-6">
                    @foreach ($cart as $index => $item)
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        @if (isset($item['image']) && $item['image'])
                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}"
                            class="w-16 h-16 object-cover rounded-lg border border-gray-100">
                        @else
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 text-gray-400">
                            <i class="fas fa-image"></i>
                        </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-primary-900 truncate">{{ $item['name'] }}</h4>
                            @if (!empty($item['variant_text']))
                            <p class="text-xs text-gray-500">{{ $item['variant_text'] }}</p>
                            @endif
                            <p class="text-sm text-secondary-600 font-bold">Q{{ number_format($item['precio'], 2) }}</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                    class="w-7 h-7 bg-gray-100 rounded-lg hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="text-sm font-semibold w-8 text-center text-gray-700">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                    class="w-7 h-7 bg-gray-100 rounded-lg hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <button wire:click="removeFromCart({{ $index }})"
                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </div>
                    @endforeach
                </div>

                <!-- Resumen -->
                <div class="bg-white rounded-xl p-4 mb-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Subtotal:</span>
                        <span class="font-bold text-gray-900">Q{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">IVA (12%):</span>
                        <span class="font-bold text-gray-900">Q{{ number_format($iva, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-gray-100 pt-3 mt-2">
                        <span class="text-primary-900">Total:</span>
                        <span class="text-secondary-600">Q{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Formulario de checkout -->
                <form wire:submit="checkout" class="space-y-4">

                    {{-- Usuario logueado: mostrar info --}}
                    @auth
                    <div class="bg-primary-50 border border-primary-100 rounded-xl p-3 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-200 text-primary-700 flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-primary-900 text-sm truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-primary-600 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <i class="fas fa-check-circle text-emerald-500"></i>
                    </div>

                    {{-- Teléfono editable --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            <i class="fas fa-phone-alt text-secondary-500 mr-1"></i> Teléfono *
                        </label>
                        <input type="tel" wire:model="telefono"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="Ej: 5555-1234" required>
                        @error('telefono')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    @else
                    {{-- Usuario invitado: pedir todos los datos --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            Nombre Completo *
                        </label>
                        <input type="text" wire:model="nombre"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="Tu nombre completo" required>
                        @error('nombre')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            Teléfono *
                        </label>
                        <input type="tel" wire:model="telefono"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="Ej: 5555-1234" required>
                        @error('telefono')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            Email (opcional)
                        </label>
                        <input type="email" wire:model="email"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="tucorreo@ejemplo.com">
                        @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Invitar a registrarse --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <a href="{{ route('register') }}" class="font-bold underline hover:text-blue-900">Crea una cuenta</a>
                            para guardar tus direcciones.
                        </p>
                    </div>
                    @endauth

                    {{-- Tipo de entrega --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Tipo de Entrega *
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" wire:click="$set('tipo_entrega', 'domicilio')"
                                class="p-3 border-2 rounded-xl transition-all text-center {{ $tipo_entrega === 'domicilio' ? 'border-secondary-500 bg-secondary-50 text-secondary-800' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                                <i class="fas fa-shipping-fast text-xl mb-1"></i>
                                <p class="font-bold text-xs">A Domicilio</p>
                            </button>

                            <button type="button" wire:click="$set('tipo_entrega', 'recoger')"
                                class="p-3 border-2 rounded-xl transition-all text-center {{ $tipo_entrega === 'recoger' ? 'border-secondary-500 bg-secondary-50 text-secondary-800' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                                <i class="fas fa-store text-xl mb-1"></i>
                                <p class="font-bold text-xs">Recoger</p>
                            </button>
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div x-show="$wire.tipo_entrega === 'domicilio'">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-secondary-500 mr-1"></i> Dirección de Entrega *
                        </label>

                        @auth
                        {{-- Usuario logueado: selector de direcciones --}}
                        @if($userAddresses->count() > 0 && !$showNewAddressForm)
                        <div class="space-y-2 mb-3">
                            @foreach($userAddresses as $address)
                            <div wire:click="selectAddress({{ $address->id }})"
                                class="p-3 border-2 rounded-xl cursor-pointer transition-all bg-white {{ $selectedAddressId == $address->id ? 'border-secondary-500 bg-secondary-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-xs font-bold text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full border border-primary-100">
                                            {{ $address->alias }}
                                        </span>
                                        @if($address->is_default)
                                        <span class="text-xs text-yellow-500 ml-1">
                                            <i class="fas fa-star"></i>
                                        </span>
                                        @endif
                                    </div>
                                    @if($selectedAddressId == $address->id)
                                    <i class="fas fa-check-circle text-secondary-500"></i>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 mt-2 leading-tight">{{ $address->full_address }}</p>
                                @if($address->referencia)
                                <p class="text-xs text-gray-500 mt-1 italic">
                                    Ref: {{ $address->referencia }}
                                </p>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <button type="button" wire:click="showNewAddress"
                            class="w-full p-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-secondary-400 hover:text-secondary-600 transition-all text-sm font-medium bg-white">
                            <i class="fas fa-plus mr-1"></i> Agregar nueva dirección
                        </button>
                        @endif

                        {{-- Formulario de nueva dirección --}}
                        @if($showNewAddressForm || $userAddresses->count() == 0)
                        <div class="space-y-3 p-4 bg-gray-100 rounded-xl border border-gray-200">
                            @if($userAddresses->count() > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-gray-800">Nueva Dirección</span>
                                <button type="button" wire:click="cancelNewAddress" class="text-xs text-red-500 hover:text-red-700 font-medium">
                                    Cancelar
                                </button>
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Alias</label>
                                <select wire:model="newAddressAlias" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-secondary-500">
                                    <option value="Casa">🏠 Casa</option>
                                    <option value="Trabajo">🏢 Trabajo</option>
                                    <option value="Oficina">💼 Oficina</option>
                                    <option value="Otro">📍 Otro</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Dirección completa *</label>
                                <textarea wire:model="direccion" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-secondary-500"
                                    placeholder="Calle, número, colonia, zona..." required></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Zona</label>
                                    <input type="text" wire:model="newAddressZona"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-secondary-500"
                                        placeholder="Ej: 10">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Referencia</label>
                                    <input type="text" wire:model="newAddressReferencia"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-secondary-500"
                                        placeholder="Ej: Portón negro">
                                </div>
                            </div>

                            <label class="flex items-center gap-2 text-sm mt-2 cursor-pointer">
                                <input type="checkbox" wire:model="saveNewAddress" class="rounded border-gray-300 text-secondary-600 focus:ring-secondary-500">
                                <span class="text-gray-700">Guardar esta dirección</span>
                            </label>
                        </div>
                        @endif
                        @else
                        {{-- Usuario invitado: solo textarea --}}
                        <textarea wire:model="direccion" rows="2"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="Zona, colonia, calle, número de casa..." required></textarea>
                        @endauth

                        @error('direccion')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-truck mr-1.5"></i>
                            Envío calculado al confirmar.
                        </p>
                    </div>

                    {{-- Recoger en tienda --}}
                    <div x-show="$wire.tipo_entrega === 'recoger'" x-cloak>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                            <p class="text-sm text-emerald-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Sede Central:</strong><br>
                                Campo Marte, Zona 5, Ciudad de Guatemala<br>
                                <span class="text-xs block mt-1 opacity-80">Horario: Lun - Sáb: 8:00 AM - 5:00 PM</span>
                            </p>
                        </div>
                    </div>

                    {{-- Notas --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            Notas Adicionales
                        </label>
                        <textarea wire:model="notas" rows="1"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-sm bg-white"
                            placeholder="Instrucciones de entrega, NIT para factura..."></textarea>
                    </div>

                    {{-- Método de pago --}}
                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            <i class="fas fa-money-bill-wave text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-primary-900 text-sm">Pago Contra Entrega</p>
                            <p class="text-xs text-primary-600">Paga en efectivo al recibir tu pedido.</p>
                        </div>
                    </div>

                    {{-- Botón confirmar --}}
                    <button type="submit"
                        class="w-full bg-secondary-500 hover:bg-secondary-400 text-primary-900 py-4 rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 flex items-center justify-center">
                        <span>Confirmar Pedido</span>
                        <i class="fas fa-arrow-right ml-2 opacity-70"></i>
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-4">
                        Al confirmar, aceptas nuestros términos y condiciones de servicio.
                    </p>
                </form>
                @else
                <!-- Carrito vacío -->
                <div class="text-center py-20 flex flex-col items-center justify-center h-full">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6 text-gray-300">
                        <i class="fas fa-shopping-basket text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h3>
                    <p class="text-gray-500 text-sm mb-8 max-w-xs mx-auto">Parece que aún no has agregado productos. ¡Explora nuestro catálogo!</p>

                    <button @click="show = false" class="px-8 py-3 bg-primary-700 text-white rounded-xl font-bold hover:bg-primary-800 transition-colors shadow-lg">
                        Ir al Catálogo
                    </button>
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