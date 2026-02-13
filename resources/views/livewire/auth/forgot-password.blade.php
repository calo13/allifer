<x-layouts.guest>
    
    <div class="text-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">¿Olvidaste tu contraseña?</h3>
        <p class="mt-2 text-sm text-gray-600">
            Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña.
        </p>
    </div>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo enviado!',
                    text: '{{ session('status') }}',
                    confirmButtonColor: '#6366f1',
                    confirmButtonText: 'Entendido'
                });
            });
        </script>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
                   placeholder="correo@ejemplo.com"
                   class="appearance-none block w-full px-4 py-3 border-2 @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Button -->
        <button type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all">
            <i class="fas fa-paper-plane mr-2"></i>
            Enviar enlace de recuperación
        </button>

        <!-- Back to login -->
        <div class="text-center text-sm pt-2">
            <span class="text-gray-600">¿Recordaste tu contraseña?</span>
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline ml-1 transition-all">
                Iniciar sesión
            </a>
        </div>
    </form>
    
</x-layouts.guest>