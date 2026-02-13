<x-layouts.guest>
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-envelope-open-text text-indigo-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900">Verifica tu email</h3>
        <p class="mt-2 text-sm text-gray-600">
            Te hemos enviado un enlace de verificación a tu correo electrónico.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
            <i class="fas fa-check-circle mr-2"></i>
            ¡Enlace de verificación enviado!
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all">
                <i class="fas fa-paper-plane mr-2"></i>Reenviar email de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 px-4 bg-white text-gray-700 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
            </button>
        </form>
    </div>
</x-layouts.guest>