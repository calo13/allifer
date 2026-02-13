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
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Crear cuenta</h2>
            <p class="text-sm text-gray-500 mt-1">Completa el formulario para registrarte</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="space-y-1">
                <label for="name" class="block text-sm font-semibold text-gray-700 ml-1">
                    Nombre completo
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Tu nombre completo"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('name') border-red-500 @enderror">
                </div>
                @error('name')
                <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

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
                        placeholder="nombre@ejemplo.com"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block text-sm font-semibold text-gray-700 ml-1">
                    Contraseña
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="Mínimo 8 caracteres"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('password') border-red-500 @enderror">
                </div>
                @error('password')
                <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 ml-1">
                    Confirmar contraseña
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Repite tu contraseña"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white">
                </div>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0 mt-2">
                <i class="fas fa-user-plus mr-2"></i>
                Registrarme
            </button>

            <!-- Login link -->
            <div class="text-center text-sm pt-2">
                <span class="text-gray-600">¿Ya tienes cuenta?</span>
                <a href="{{ route('login') }}" class="font-bold text-secondary-600 hover:text-secondary-500 hover:underline ml-1 transition-all">
                    Iniciar sesión
                </a>
            </div>
        </form>
    </div>

</x-layouts.guest>