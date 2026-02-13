<div>
    <!-- Header mejorado -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-tags text-purple-600 mr-3"></i>
                    Categorías
                </h1>
                <p class="mt-2 text-sm text-gray-600">Organiza tus productos en categorías</p>
            </div>
            <button wire:click="create" 
                    class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-primary-600 hover:from-purple-700 hover:to-primary-700 text-white text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-plus-circle mr-2"></i>
                Nueva Categoría
            </button>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar categorías..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
            </div>
            <div class="flex items-center space-x-3">
                <i class="fas fa-filter text-gray-400"></i>
                <select wire:model.live="perPage" 
                        class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white">
                    <option value="10">10 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                    <option value="100">100 por página</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-tag mr-2"></i>Categoría
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-box mr-2"></i>Productos
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-toggle-on mr-2"></i>Estado
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-cog mr-2"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-primary-50 transition-all duration-200 {{ !$category->active ? 'opacity-60' : '' }}">
                            <!-- Categoría -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $category->name }}
                                    </div>
                                    @if($category->description)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ Str::limit($category->description, 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Productos -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <i class="fas fa-boxes mr-1.5"></i>
                                    {{ $category->products_count }} productos
                                </span>
                            </td>

                            <!-- Estado -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($category->active)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-md">
                                        <i class="fas fa-check-circle mr-1.5"></i>Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-md">
                                        <i class="fas fa-times-circle mr-1.5"></i>Inactivo
                                    </span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if (!$category->active)
                                        <button wire:click="toggleActive({{ $category->id }})"
                                                class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activar
                                        </button>
                                    @endif
                                    
                                    <button wire:click="edit({{ $category->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-primary-600 hover:from-blue-600 hover:to-primary-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                        <i class="fas fa-edit mr-1"></i>
                                        Editar
                                    </button>
                                    
                                    @if ($category->active)
                                        <button onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')"
                                                class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                                            <i class="fas fa-trash-alt mr-1"></i>
                                            Eliminar
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-gradient-to-br from-purple-100 to-primary-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-tags text-4xl text-purple-400"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 mb-2">No hay categorías</p>
                                    <p class="text-sm text-gray-500 mb-4">Crea tu primera categoría para organizar los productos</p>
                                    <button wire:click="create" 
                                            class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-all">
                                        <i class="fas fa-plus mr-2"></i>
                                        Crear Categoría
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
<!-- Modal -->
@if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 wire:click="close"></div>

            <!-- Modal panel - AGREGADO z-50 relative -->
            <div class="relative z-50 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-600 to-primary-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-{{ $editMode ? 'edit' : 'plus-circle' }} mr-2"></i>
                            {{ $editMode ? 'Editar' : 'Nueva' }} Categoría
                        </h3>
                        <button wire:click="close" type="button" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <form wire:submit="save">
                    <div class="px-6 py-4 space-y-4">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-purple-500 mr-1"></i>
                                Nombre *
                            </label>
                            <input type="text" 
                                   wire:model="name"
                                   placeholder="Ej: Abarrotes"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                            @error('name')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left text-purple-500 mr-1"></i>
                                Descripción
                            </label>
                            <textarea wire:model="description" 
                                      rows="3"
                                      placeholder="Descripción de la categoría (opcional)"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all resize-none"></textarea>
                            @error('description')
                                <span class="text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="active"
                                   id="active"
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <label for="active" class="ml-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Categoría activa
                            </label>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" 
                                wire:click="close"
                                class="px-4 py-2 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium rounded-lg transition-all">
                            <i class="fas fa-times mr-1"></i>
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-primary-600 hover:from-purple-700 hover:to-primary-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-save mr-1"></i>
                            {{ $editMode ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
    <!-- JavaScript para confirmación de eliminación -->
    @push('scripts')
    <script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: '¿Eliminar categoría?',
            html: `¿Estás seguro de eliminar "<strong>${name}</strong>"?<br><small class="text-gray-500">Si tiene productos, solo se desactivará.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
            }
        });
    }
    </script>
    @endpush
</div>
