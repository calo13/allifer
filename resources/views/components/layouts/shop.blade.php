<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallifer Agro-Tecnología - Tienda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative w-10 h-10 overflow-hidden rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                        <img src="{{ asset('images/gallifer.jpeg') }}" alt="Gallifer" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-primary-900 block leading-none">Gallifer</span>
                        <span class="text-[10px] uppercase tracking-widest text-primary-600 font-semibold">Agro-Tecnología</span>
                    </div>
                </a>

                <!-- Buscador -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <form action="{{ route('catalogo') }}" method="GET" class="w-full relative">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar productos, equipos o medicinas..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 text-sm transition-all">
                        <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400"></i>
                    </form>
                </div>

                <!-- Carrito y Usuario -->
                <div class="flex items-center space-x-6">
                    @livewire('shop.cart-icon')

                    @auth
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden lg:block">{{ auth()->user()->name }}</span>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-800 transition-colors">
                        Iniciar Sesión
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    @livewire('shop.cart')

    <!-- Footer -->
    <footer class="bg-primary-900 text-gray-300 py-12 border-t border-primary-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-white p-1 rounded">
                            <img src="{{ asset('images/gallifer.jpeg') }}" alt="Gallifer" class="h-8 w-8 object-cover rounded-sm">
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">Gallifer</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Soluciones integrales: agricultura, avicultura, mascotas y tecnología. Todo para su producción y cuidado animal.
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('catalogo') }}" class="hover:text-secondary-400 transition-colors">Catálogo Completo</a></li>
                        <li><a href="{{ route('home') }}#tecnologia" class="hover:text-secondary-400 transition-colors">Tecnología</a></li>
                        <li><a href="{{ route('cliente.pedidos') }}" class="hover:text-secondary-400 transition-colors">Mis Pedidos</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-2 text-secondary-500"></i> Zona 5, Ciudad de Guatemala</li>
                        <li class="flex items-center"><i class="fas fa-phone mr-2 text-secondary-500"></i> +502 4576 1805</li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-2 text-secondary-500"></i> ventas@gallifer.com</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-primary-800 flex items-center justify-center hover:bg-secondary-500 hover:text-primary-900 transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-primary-800 flex items-center justify-center hover:bg-secondary-500 hover:text-primary-900 transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/50245761805" class="w-10 h-10 rounded-full bg-primary-800 flex items-center justify-center hover:bg-secondary-500 hover:text-primary-900 transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-primary-800 mt-12 pt-8 text-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Gallifer Agro-Tecnología. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>