<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-gift text-white text-xl"></i>
                    </div>
                    {{ $promotion ? 'Editar Promoción' : 'Nueva Promoción' }}
                </h1>
                <p class="mt-2 ml-16 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-pink-500 mr-1"></i>
                    Configura los detalles de tu oferta y selecciona los productos
                </p>
            </div>
            <a href="{{ route('admin.promotions.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 hover:border-pink-500 text-gray-700 hover:text-pink-600 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al listado
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COLUMNA IZQUIERDA (2/3) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Información Básica -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Detalles de la Oferta</h2>
                    </div>

                    <div class="space-y-4">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-pink-500 mr-1"></i>Nombre de la Promoción *
                            </label>
                            <input type="text" wire:model="name" placeholder="Ej: Oferta Día del Cariño"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                            @error('name') <span class="text-red-500 text-xs flex items-center mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left text-pink-500 mr-1"></i>Descripción (Opcional)
                            </label>
                            <textarea wire:model="description" rows="2" placeholder="Detalles internos de la promoción..."
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Configuración del Descuento -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-percentage text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Reglas de Descuento</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tipo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Descuento</label>
                            <select wire:model.live="type" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                                <option value="porcentaje">Porcentaje (%)</option>
                                <option value="monto_fijo">Monto Fijo (Q)</option>
                            </select>
                        </div>

                        <!-- Valor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $type == 'porcentaje' ? 'Porcentaje (%)' : 'Monto a descontar (Q)' }}
                            </label>
                            <div class="relative">
                                @if($type == 'monto_fijo')
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Q</span>
                                @endif
                                <input type="number"
                                    wire:model="{{ $type == 'porcentaje' ? 'descuento_porcentaje' : 'descuento_monto' }}"
                                    step="0.01" min="0" {{ $type == 'porcentaje' ? 'max=100' : '' }}
                                    class="w-full {{ $type == 'monto_fijo' ? 'pl-8' : 'px-4' }} py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all font-bold text-green-700">
                            </div>
                            @error('descuento_porcentaje') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @error('descuento_monto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fechas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                            <input type="datetime-local" wire:model="fecha_inicio"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                            <input type="datetime-local" wire:model="fecha_fin"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                            @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Selección de Productos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-boxes text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Productos Aplicables</h2>
                        <span class="ml-auto text-xs bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-medium">
                            {{ count($selectedProducts) }} seleccionados
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($products as $product)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors {{ in_array($product->id, $selectedProducts) ? 'bg-amber-50 border-amber-300 ring-1 ring-amber-300' : '' }}">
                            <input type="checkbox" wire:model.live="selectedProducts" value="{{ $product->id }}"
                                class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-medium text-gray-900 line-clamp-1">{{ $product->name }}</span>
                                <span class="block text-xs text-gray-500">Q{{ number_format($product->precio_venta, 2) }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-3 pt-3 border-t">
                        <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                        Selecciona los productos que tendrán aplicado este descuento.
                    </p>
                </div>

            </div>

            <!-- COLUMNA DERECHA (1/3) -->
            <div class="space-y-6">

                <!-- Estado -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-toggle-on text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Estado</h2>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Activar Promoción</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Resumen (Opcional o Stats) -->
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="font-bold text-lg mb-2">Resumen</h3>
                    <ul class="space-y-2 text-sm text-pink-100">
                        <li class="flex justify-between">
                            <span>Tipo:</span>
                            <span class="font-bold text-white capitalize">{{ str_replace('_', ' ', $type) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Descuento:</span>
                            <span class="font-bold text-white">
                                {{ $type == 'porcentaje' ? $descuento_porcentaje . '%' : 'Q' . number_format($descuento_monto, 2) }}
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span>Productos:</span>
                            <span class="font-bold text-white">{{ count($selectedProducts) }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Botones de Acción -->
                <div class="space-y-3 pt-4">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Promoción
                    </button>
                    <a href="{{ route('admin.promotions.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 hover:text-gray-900 font-medium rounded-xl hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>