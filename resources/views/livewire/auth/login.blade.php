<x-layouts.guest>

    <div class="bg-white py-10 px-8 shadow-2xl rounded-3xl border border-gray-100 relative overflow-hidden">

        <!-- Decorative Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-600 via-primary-500 to-secondary-500"></div>

        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-block relative mb-4">
                <div class="absolute inset-0 bg-primary-100 rounded-full blur-xl opacity-50 transform scale-150"></div>
                <img src="{{ asset('images/gallifer.jpeg') }}"
                    alt="Gallifer"
                    class="h-24 w-auto relative z-10 mx-auto drop-shadow-sm hover:scale-105 transition-transform duration-300">
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Bienvenido</h2>
            <p class="text-sm text-gray-500 mt-1">Ingresa a tu cuenta para continuar</p>
        </div>

        @if (session('status'))
        <div class="mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            {{ session('status') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 rounded-xl p-4">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <h3 class="text-sm font-bold text-red-800">No pudimos iniciar sesión</h3>
            </div>
            <ul class="list-disc list-inside text-xs text-red-600 pl-1 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="block text-sm font-semibold text-gray-700 ml-1">
                    Correo Electrónico
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white"
                        placeholder="ejemplo@correo.com">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex items-center justify-between ml-1">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        Contraseña
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-primary-600 hover:text-primary-500 hover:underline transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                    @endif
                </div>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password"
                        type="password"
                        name="password"
                        required
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center ml-1">
                <input id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition-colors cursor-pointer">
                <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                    Recordar mi sesión
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                Iniciar Sesión
                <i class="fas fa-arrow-right ml-2 text-xs opacity-70"></i>
            </button>

            <!-- Register Link -->
            @if (Route::has('register'))
            <div class="relative text-center mt-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-500">
                        ¿Aún no tienes cuenta?
                    </span>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center text-sm font-bold text-secondary-600 hover:text-secondary-500 hover:underline transition-colors p-2">
                    Crear cuenta nueva
                </a>
            </div>
            @endif
        </form>
    </div>

</x-layouts.guest>