<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user-friends text-primary-600 mr-3"></i>
                    Clientes
                </h1>
                <p class="mt-2 text-sm text-gray-600">Gestiona la base de datos de clientes</p>
            </div>
            <a href="{{ route('admin.customers.create') }}"
                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-plus-circle mr-2"></i>
                Nuevo Cliente
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
    <div class="mb-6 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Búsqueda -->
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nombre, NIT, email o teléfono..."
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>

            <!-- Filtro por Tipo -->
            <select wire:model.live="filterTipo"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los tipos</option>
                <option value="consumidor_final">Consumidor Final</option>
                <option value="empresa">Empresa</option>
            </select>

            <!-- Filtro por Estado -->
            <select wire:model.live="filterActivo"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </select>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-user mr-2"></i>Cliente
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-id-card mr-2"></i>NIT
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-envelope mr-2"></i>Contacto
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-tag mr-2"></i>Tipo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-dollar-sign mr-2"></i>Total Gastado
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-toggle-on mr-2"></i>Estado
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-cog mr-2"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    {{ $customer->initials() }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $customer->nombre }}</div>
                                    @if($customer->hasUser())
                                    <span class="text-xs text-primary-600">
                                        <i class="fas fa-globe"></i> Tiene acceso online
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $customer->nit }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($customer->email)
                            <div class="text-gray-900">{{ $customer->email }}</div>
                            @endif
                            @if($customer->telefono)
                            <div class="text-gray-600">
                                <i class="fas fa-phone mr-1"></i>{{ $customer->telefono }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($customer->isEmpresa())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-building mr-1"></i>Empresa
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-user mr-1"></i>Consumidor Final
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">
                            Q{{ number_format($customer->total_gastado, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($customer->activo)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Activo
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-times-circle mr-1"></i>Inactivo
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @if($customer->email)
                                <button wire:click="inviteUser({{ $customer->id }})"
                                    wire:confirm="¿Estás seguro de enviar una invitación a {{ $customer->email }}?"
                                    class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 text-xs"
                                    title="Invitar/Reenviar usuario">
                                    <i class="fas fa-envelope mr-1"></i> {{ $customer->hasUser() ? 'Reenviar' : 'Invitar' }}
                                </button>
                                @endif

                                <button wire:click="toggleActivo({{ $customer->id }})"
                                    class="px-3 py-1 {{ $customer->activo ? 'bg-gray-100 text-gray-700' : 'bg-green-100 text-green-700' }} rounded-lg hover:opacity-80 text-xs">
                                    <i class="fas fa-{{ $customer->activo ? 'ban' : 'check' }} mr-1"></i>
                                    {{ $customer->activo ? 'Desactivar' : 'Activar' }}
                                </button>

                                <a href="{{ route('admin.customers.edit', $customer) }}"
                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-xs">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-user-friends text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg font-medium text-gray-900">No se encontraron clientes</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>