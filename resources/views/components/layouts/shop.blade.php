<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Tienda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">{{ config('app.name') }}</span>
                </a>

                <!-- Buscador -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar productos..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </form>
                </div>

                <!-- Carrito y Usuario -->
                <div class="flex items-center space-x-4">
                    @livewire('shop.cart-icon')

                    @auth
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-circle text-gray-600 text-xl"></i>
                        <span class="text-sm text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Iniciar Sesión
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    @livewire('shop.cart')

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ config('app.name') }}</h3>
                    <p class="text-gray-400 text-sm">Tu tienda en línea de confianza</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contacto</h3>
                    <p class="text-gray-400 text-sm">
                        <i class="fas fa-phone mr-2"></i> +502 1234-5678<br>
                        <i class="fas fa-envelope mr-2"></i> info@tienda.com
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-whatsapp text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>