<x-layouts.public>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            <i class="fas fa-user text-indigo-600 mr-2"></i>
            Mi Perfil
        </h1>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Header con foto --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 text-center">
                <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg mb-4">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                        alt="{{ auth()->user()->name }}"
                        class="w-full h-full object-cover rounded-full">
                    @else
                    <span class="text-3xl font-bold text-indigo-600">{{ auth()->user()->initials() }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h2>
                <p class="text-indigo-200">{{ auth()->user()->email }}</p>
            </div>

            {{-- Formulario --}}
            <form action="{{ route('cliente.perfil.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Foto de perfil --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera text-indigo-600 mr-1"></i> Foto de perfil
                    </label>
                    <input type="file" name="avatar" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG. Máximo 2MB.</p>
                    @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-indigo-600 mr-1"></i> Nombre completo
                    </label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Email (solo lectura) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-indigo-600 mr-1"></i> Correo electrónico
                    </label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">
                    <p class="text-xs text-gray-500 mt-1">El correo no se puede cambiar.</p>
                </div>

                {{-- Botón guardar --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-save mr-2"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">
                <i class="fas fa-lock text-indigo-600 mr-2"></i> Cambiar contraseña
            </h3>
            <form action="{{ route('cliente.perfil.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña actual</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva contraseña</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-900 transition-colors">
                    <i class="fas fa-key mr-2"></i> Cambiar contraseña
                </button>
            </form>
        </div>
    </div>
</x-layouts.public>