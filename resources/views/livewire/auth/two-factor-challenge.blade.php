<x-layouts.guest>

    <div class="bg-white py-10 px-8 shadow-2xl rounded-3xl border border-gray-100 relative overflow-hidden">

        <!-- Decorative Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-600 via-primary-500 to-secondary-500"></div>

        <!-- Logo/Icon Section -->
        <div class="text-center mb-8">
            <div class="inline-block relative mb-4">
                <div class="absolute inset-0 bg-primary-100 rounded-full blur-xl opacity-50 transform scale-150"></div>
                <div class="relative z-10 w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mx-auto">
                    <i class="fas fa-shield-alt text-3xl text-primary-600"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Verificación en dos pasos</h2>
            <p class="text-sm text-gray-500 mt-1">
                Ingresa el código de autenticación para continuar.
            </p>
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
            @csrf

            <!-- Code -->
            <div class="space-y-1">
                <label for="code" class="block text-sm font-semibold text-gray-700 ml-1">
                    Código de autenticación
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-key text-gray-400"></i>
                    </div>
                    <input id="code"
                        type="text"
                        name="code"
                        required
                        autofocus
                        placeholder="Ingresa el código"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white tracking-widest text-center font-mono">
                </div>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                <i class="fas fa-unlock mr-2"></i>
                Verificar
            </button>
        </form>
    </div>

</x-layouts.guest>