<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-users text-primary-600 mr-3"></i>
                    Usuarios
                </h1>
                <p class="mt-2 text-sm text-gray-600">Gestiona los usuarios y sus roles</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-plus-circle mr-2"></i>
                Nuevo Usuario
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

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Búsqueda -->
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar por nombre o email..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>

            <!-- Filtro por Rol -->
            <select wire:model.live="filterRole" 
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <!-- Filtro por Estado -->
            <select wire:model.live="filterActive" 
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </select>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-user mr-2"></i>Usuario
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-shield-alt mr-2"></i>Rol
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
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800">
                                            <i class="fas fa-shield-alt mr-1"></i>
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-gray-400 italic">Sin rol</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->active)
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
                                    <button wire:click="toggleActive({{ $user->id }})"
                                            class="px-3 py-1 {{ $user->active ? 'bg-gray-100 text-gray-700' : 'bg-green-100 text-green-700' }} rounded-lg hover:opacity-80 text-xs">
                                        <i class="fas fa-{{ $user->active ? 'ban' : 'check' }} mr-1"></i>
                                        {{ $user->active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                    
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-xs">
                                        <i class="fas fa-edit mr-1"></i>Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-lg font-medium text-gray-900">No se encontraron usuarios</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
