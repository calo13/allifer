<x-layouts.guest>

    <div class="bg-white py-10 px-8 shadow-2xl rounded-3xl border border-gray-100 relative overflow-hidden">

        <!-- Decorative Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-600 via-primary-500 to-secondary-500"></div>

        <!-- Logo/Icon Section -->
        <div class="text-center mb-8">
            <div class="inline-block relative mb-4">
                <div class="absolute inset-0 bg-primary-100 rounded-full blur-xl opacity-50 transform scale-150"></div>
                <div class="relative z-10 w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-md mx-auto">
                    <i class="fas fa-envelope-open-text text-4xl text-primary-600"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Verifica tu email</h2>
            <p class="text-sm text-gray-500 mt-2 max-w-xs mx-auto">
                Te hemos enviado un enlace de verificación a tu correo electrónico.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            <span>¡Enlace de verificación enviado!</span>
        </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Reenviar email de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex justify-center items-center py-3.5 px-4 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 hover:text-red-500 hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>

</x-layouts.guest>