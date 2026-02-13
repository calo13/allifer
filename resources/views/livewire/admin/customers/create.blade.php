<div>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Volver a Clientes
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Crear Nuevo Cliente</h1>
            <p class="mt-1 text-sm text-gray-600">Registra un nuevo cliente en el sistema</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form wire:submit="save">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i> Nombre Completo *
                        </label>
                        <input type="text" 
                               wire:model="nombre" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="Ej: Juan Pérez">
                        @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- NIT -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card mr-1"></i> NIT *
                        </label>
                        <input type="text" 
                               wire:model="nit" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="CF o número de NIT">
                        @error('nit') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1"></i> Tipo *
                        </label>
                        <select wire:model="tipo" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                            <option value="consumidor_final">Consumidor Final</option>
                            <option value="empresa">Empresa</option>
                        </select>
                        @error('tipo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i> Email
                        </label>
                        <input type="email" 
                               wire:model="email" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="cliente@ejemplo.com">
                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1"></i> Teléfono
                        </label>
                        <input type="text" 
                               wire:model="telefono" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="5555-5555">
                        @error('telefono') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i> Dirección
                        </label>
                        <textarea wire:model="direccion" 
                                  rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                  placeholder="Dirección completa del cliente"></textarea>
                        @error('direccion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descuento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-percent mr-1"></i> Descuento (%)
                        </label>
                        <input type="number" 
                               wire:model="descuento_porcentaje" 
                               step="0.01"
                               min="0"
                               max="100"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="0.00">
                        @error('descuento_porcentaje') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Límite de Crédito -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-credit-card mr-1"></i> Límite de Crédito
                        </label>
                        <input type="number" 
                               wire:model="limite_credito" 
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="0.00">
                        @error('limite_credito') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Estado -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="activo" 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                   checked>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                <i class="fas fa-check-circle mr-1"></i> Cliente activo
                            </span>
                        </label>
                    </div>

                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t">
                    <a href="{{ route('admin.customers.index') }}" 
                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded-lg hover:from-primary-700 hover:to-purple-700 transition-all">
                        <i class="fas fa-save mr-2"></i> Crear Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
