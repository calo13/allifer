<x-layouts.guest>
    
    <div class="text-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Iniciar Sesión</h3>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
            {{ session('status') }}
        </div>
    @endif

    <!-- SweetAlert para errores -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de autenticación',
                    html: `
                        <div class="text-left">
                            @foreach ($errors->all() as $error)
                                <p class="text-gray-700 mb-2">• {{ $error }}</p>
                            @endforeach
                        </div>
                    `,
                    confirmButtonColor: '#6366f1',
                    confirmButtonText: 'Intentar de nuevo',
                    allowOutsideClick: false
                });
            });
        </script>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

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
                   autofocus
                   class="appearance-none block w-full px-4 py-3 border-2 @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
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
                   class="appearance-none block w-full px-4 py-3 border-2 @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                    Recordarme
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 hover:underline transition-all">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Button -->
        <button type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Iniciar Sesión
        </button>

        <!-- Register link -->
        @if (Route::has('register'))
            <div class="text-center text-sm pt-2">
                <span class="text-gray-600">¿No tienes cuenta?</span>
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline ml-1 transition-all">
                    Regístrate aquí
                </a>
            </div>
        @endif
    </form>
    
</x-layouts.guest>