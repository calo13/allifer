<x-layouts.guest>

    <div class="bg-white py-10 px-8 shadow-2xl rounded-3xl border border-gray-100 relative overflow-hidden">

        <!-- Decorative Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-600 via-primary-500 to-secondary-500"></div>

        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-block relative mb-4">
                <div class="absolute inset-0 bg-primary-100 rounded-full blur-xl opacity-50 transform scale-150"></div>
                <div class="relative z-10 w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mx-auto">
                    <i class="fas fa-key text-3xl text-primary-600"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Recuperar Contraseña</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">
                Ingresa tu email y te enviaremos las instrucciones para restablecerla.
            </p>
        </div>

        @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo enviado!',
                    text: '{{ session('
                    status ') }}',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl font-bold'
                    }
                });
            });
        </script>
        <div class="mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center">
            <i class="fas fa-paper-plane mr-3 text-lg"></i>
            <span>Te hemos enviado el enlace de recuperación.</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                        placeholder="nombre@ejemplo.com"
                        class="block w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                <i class="fas fa-paper-plane mr-2"></i>
                Enviar enlace
            </button>

            <!-- Back to login -->
            <div class="text-center text-sm pt-2">
                <a href="{{ route('login') }}" class="inline-flex items-center font-bold text-gray-500 hover:text-primary-600 transition-colors group">
                    <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>

</x-layouts.guest>