<div>
    @if($showModal)
        <!-- Card flotante compacto -->
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[9999] w-96">
            <div class="bg-white rounded-lg shadow-2xl border-2 border-primary-500 overflow-hidden">
                
                <!-- Header compacto -->
                <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-white flex items-center">
                        <i class="fas fa-user-plus mr-2 text-xs"></i>
                        Nuevo Cliente
                    </h3>
                    <button type="button" 
                            wire:click="closeModal" 
                            class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Body compacto -->
                <form wire:submit="save" class="p-4 space-y-3">
                    <!-- NIT -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            <i class="fas fa-id-card text-primary-600 mr-1"></i> NIT
                        </label>
                        <input type="text" 
                               wire:model="nit" 
                               readonly
                               class="w-full px-3 py-1.5 text-sm bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            <i class="fas fa-user text-primary-600 mr-1"></i> Nombre *
                        </label>
                        <input type="text" 
                               wire:model="nombre"
                               placeholder="Juan Pérez"
                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('nombre') 
                            <span class="text-red-600 text-xs mt-0.5 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Email y Teléfono en una fila -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                <i class="fas fa-envelope text-primary-600 mr-1"></i> Email
                            </label>
                            <input type="email" 
                                   wire:model="email"
                                   placeholder="correo@ejemplo.com"
                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                <i class="fas fa-phone text-primary-600 mr-1"></i> Teléfono
                            </label>
                            <input type="text" 
                                   wire:model="telefono"
                                   placeholder="5555-5555"
                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="flex gap-2 pt-2">
                        <button type="button" 
                                wire:click="closeModal"
                                class="flex-1 px-3 py-1.5 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-3 py-1.5 text-sm bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded hover:from-primary-700 hover:to-purple-700 font-medium shadow">
                            <i class="fas fa-save mr-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
