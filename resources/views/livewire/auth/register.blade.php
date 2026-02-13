<x-layouts.guest>
    
    <div class="text-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Crear cuenta</h3>
        <p class="mt-2 text-sm text-gray-600">
            Completa el formulario para registrarte
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-user mr-1 text-indigo-600"></i>
                Nombre completo
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus
                   placeholder="Tu nombre"
                   class="appearance-none block w-full px-4 py-3 border-2 @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-envelope mr-1 text-indigo-600"></i>
                Email
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required
                   placeholder="correo@ejemplo.com"
                   class="appearance-none block w-full px-4 py-3 border-2 @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-lock mr-1 text-indigo-600"></i>
                Contraseña
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required
                   placeholder="Mínimo 8 caracteres"
                   class="appearance-none block w-full px-4 py-3 border-2 @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-lock mr-1 text-indigo-600"></i>
                Confirmar contraseña
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required
                   placeholder="Repite tu contraseña"
                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
        </div>

        <!-- Button -->
        <button type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all">
            <i class="fas fa-user-plus mr-2"></i>
            Crear cuenta
        </button>

        <!-- Login link -->
        <div class="text-center text-sm pt-2">
            <span class="text-gray-600">¿Ya tienes cuenta?</span>
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline ml-1 transition-all">
                Iniciar sesión
            </a>
        </div>
    </form>
    
</x-layouts.guest>