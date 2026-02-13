<x-layouts.guest>
    <div class="text-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Confirmar contraseña</h3>
        <p class="mt-2 text-sm text-gray-600">
            Por favor confirma tu contraseña antes de continuar.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-lock mr-1 text-indigo-600"></i>
                Contraseña
            </label>
            <input id="password" type="password" name="password" required
                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all">
            <i class="fas fa-check mr-2"></i>Confirmar
        </button>
    </form>
</x-layouts.guest>