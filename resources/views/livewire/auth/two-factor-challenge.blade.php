<x-layouts.guest>
    <div class="text-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Verificación en dos pasos</h3>
        <p class="mt-2 text-sm text-gray-600">Ingresa el código de autenticación</p>
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-4">
        @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-shield-alt mr-1 text-indigo-600"></i>Código de autenticación
            </label>
            <input id="code" type="text" name="code" required autofocus
                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all">
            <i class="fas fa-unlock mr-2"></i>Verificar
        </button>
    </form>
</x-layouts.guest>