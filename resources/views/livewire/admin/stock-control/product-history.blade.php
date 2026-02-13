<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
   <a href="{{ route('admin.stock-control.index') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm mb-4">
    <i class="fas fa-arrow-left mr-2"></i> Volver al Control de Stock
</a>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-history text-primary-600 mr-3"></i>
                        Historial de Movimientos
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Producto: <strong>{{ $product->name }}</strong> | SKU: {{ $product->sku }}
                    </p>
                </div>
                
                <div class="text-right">
                    <div class="text-sm text-gray-600">Stock Actual</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $product->stock }}</div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-filter text-gray-400"></i>
                    <select wire:model.live="filterType"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                        <option value="">Todos los tipos</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                        <option value="ajuste">Ajuste</option>
                        <option value="devolucion">Devolución</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar text-gray-400"></i>
                    <input type="date"
                        wire:model.live="filterDate"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-calendar mr-2"></i>Fecha
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-tag mr-2"></i>Tipo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-sort-numeric-up mr-2"></i>Cantidad
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-warehouse mr-2"></i>Stock Antes/Después
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-comment mr-2"></i>Motivo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <i class="fas fa-user mr-2"></i>Usuario
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($movements as $movement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $movement->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $colors = [
                                    'entrada' => 'bg-green-100 text-green-800',
                                    'salida' => 'bg-red-100 text-red-800',
                                    'ajuste' => 'bg-blue-100 text-blue-800',
                                    'devolucion' => 'bg-yellow-100 text-yellow-800',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$movement->type] }}">
                                    {{ ucfirst($movement->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $movement->stock_antes }} <i class="fas fa-arrow-right mx-2 text-gray-400"></i> <strong>{{ $movement->stock_despues }}</strong>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium">{{ $movement->motivo }}</div>
                                @if($movement->notas)
                                <div class="text-xs text-gray-500">{{ $movement->notas }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $movement->user->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="$dispatch('anular-movimiento', { id: {{ $movement->id }} })"
                                    class="px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-xs">
                                    <i class="fas fa-ban mr-1"></i> Anular
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600">No hay movimientos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($movements->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $movements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
