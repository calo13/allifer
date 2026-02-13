<div class="max-w-7xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fas fa-tags text-white text-xl"></i>
                </div>
                Promociones y Ofertas
            </h1>
            <p class="mt-2 ml-16 text-sm text-gray-600">
                Gestiona tus descuentos y compañas estacionales
            </p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Add view button -->
            <a href="{{ route('admin.promotions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-plus mr-2"></i>
                <span class="hidden xs:block">Nueva Promoción</span>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Toolbar -->
        <header class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-gray-800 flex items-center">
                Todas las Promociones
                <span class="ml-2 px-2.5 py-0.5 rounded-full bg-pink-100 text-pink-700 text-xs font-bold">{{ $promotions->total() }}</span>
            </h2>

            <div class="relative w-full sm:w-72">
                <input wire:model.live="search" type="text"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all text-sm"
                    placeholder="Buscar por nombre...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left">
                <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap lg:w-1/3">Promoción</th>
                        <th class="px-6 py-4 whitespace-nowrap">Descuento</th>
                        <th class="px-6 py-4 whitespace-nowrap">Vigencia</th>
                        <th class="px-6 py-4 whitespace-nowrap text-center">Estado</th>
                        <th class="px-6 py-4 whitespace-nowrap text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($promotions as $promotion)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <!-- Nombre y Productos -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center mr-3 text-pink-500 group-hover:bg-pink-100 transition-colors">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $promotion->name }}</div>
                                    <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                        <i class="fas fa-box-open mr-1 text-gray-400"></i>
                                        {{ $promotion->products_count ?? $promotion->products()->count() }} productos aplicables
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Descuento Tag -->
                        <td class="px-6 py-4">
                            @if($promotion->type == 'porcentaje')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                <i class="fas fa-percentage mr-1.5"></i>
                                {{ $promotion->descuento_porcentaje }}% OFF
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                <i class="fas fa-dollar-sign mr-1.5"></i>
                                -Q{{ number_format($promotion->descuento_monto, 2) }}
                            </span>
                            @endif
                        </td>

                        <!-- Vigencia -->
                        <td class="px-6 py-4 text-gray-600">
                            <div class="flex flex-col text-xs">
                                <span class="flex items-center mb-1">
                                    <i class="fas fa-calendar-alt w-4 text-gray-400 mr-1"></i>
                                    <span class="font-medium text-gray-700">Inicio:</span>
                                    <span class="ml-1">{{ $promotion->fecha_inicio ? $promotion->fecha_inicio->format('d M, Y') : 'Inmediato' }}</span>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-flag-checkered w-4 text-gray-400 mr-1"></i>
                                    <span class="font-medium text-gray-700">Fin:</span>
                                    <span class="ml-1 {{ $promotion->fecha_fin && $promotion->fecha_fin->isPast() ? 'text-red-500 font-bold' : '' }}">
                                        {{ $promotion->fecha_fin ? $promotion->fecha_fin->format('d M, Y') : 'Indefinido' }}
                                    </span>
                                </span>
                            </div>
                        </td>

                        <!-- Toggle Estado -->
                        <td class="px-6 py-4 text-center">
                            <button wire:click="toggleActive({{ $promotion->id }})"
                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 {{ $promotion->active ? 'bg-green-500' : 'bg-gray-200' }}">
                                <span class="sr-only">Toggle active</span>
                                <span aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 {{ $promotion->active ? 'translate-x-5' : 'translate-x-0' }}">
                                </span>
                            </button>
                            <div class="text-[10px] mt-1 font-medium {{ $promotion->active ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $promotion->active ? 'Activa' : 'Inactiva' }}
                            </div>
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.promotions.edit', $promotion->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors"
                                    title="Editar">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <button wire:click="delete({{ $promotion->id }})"
                                    wire:confirm="¿Estás seguro de eliminar esta promoción? Esta acción no se puede deshacer."
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors"
                                    title="Eliminar">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-tags text-gray-300 text-3xl"></i>
                                </div>
                                <h3 class="text-gray-900 font-medium text-lg">No hay promociones encontradas</h3>
                                <p class="text-gray-500 mt-1 max-w-sm">No hemos encontrado promociones que coincidan con tu búsqueda o aún no has creado ninguna.</p>
                                <button wire:click="$set('search', '')" class="mt-4 text-pink-600 hover:text-pink-700 font-medium text-sm">
                                    Limpiar búsqueda
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $promotions->links() }}
        </div>
    </div>
</div>