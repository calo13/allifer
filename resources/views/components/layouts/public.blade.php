@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es" x-data="{ mobileMenuOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Cariñitos GT' }} - Regalos Personalizados</title>
    <link rel="icon" href="{{ asset('images/logo-tienda.png') }}" type="image/png">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Cariñitos GT - Regalos personalizados, sublimación y bordados en Guatemala.">
    <meta name="keywords" content="sublimación, regalos, bordados, playeras, tazas, Guatemala">
    <meta name="author" content="Cariñitos GT">

    <!-- Open Graph -->
    <meta property="og:title" content="Cariñitos GT - Regalos Personalizados">
    <meta property="og:description" content="Detalles únicos para personas especiales. Sublimación y bordados.">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Optimización de imágenes */
        .img-optimized {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        /* Navbar transition */
        .navbar-scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        /* Mejor rendering de fuentes */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Animación suave para cards */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
        }

        /* 3D Transform Utilities */
        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .rotate-y-12 {
            transform: rotateY(12deg);
        }

        /* Blobs Animation */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        /* Float Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
        }

        @keyframes float-medium {

            0%,
            100% {
                transform: translateY(0px) rotate(3deg);
            }

            50% {
                transform: translateY(-15px) rotate(-1deg);
            }
        }

        @keyframes float-fast {

            0%,
            100% {
                transform: translateY(0px) rotate(-12deg);
            }

            50% {
                transform: translateY(-10px) rotate(-8deg);
            }
        }

        .animate-float-slow {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-medium {
            animation: float-medium 5s ease-in-out infinite;
        }

        .animate-float-fast {
            animation: float-fast 4s ease-in-out infinite;
        }

        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }
    </style>
</head>

<body class="bg-white">

    <!-- Carrito flotante GLOBAL - Disponible en todas las páginas -->
    @livewire('shop.cart')

    <!-- Navbar con efecto de scroll -->
    <nav class="sticky top-0 z-50 border-b transition-all duration-300"
        :class="scrolled ? 'navbar-scrolled border-gray-100' : 'bg-white border-gray-200'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo - Visible en móvil -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3">
                    <img src="{{ asset('images/logo-tienda.png') }}" alt="Cariñitos GT" class="h-10 sm:h-12 w-auto">
                    <div>
                        <span class="text-lg sm:text-xl font-bold text-gray-900">Cariñitos</span><span class="text-lg sm:text-xl font-bold text-pink-600">GT</span>
                        <span class="hidden sm:block text-xs text-gray-500 -mt-1">Regalos Personalizados</span>
                    </div>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-pink-600 transition-colors font-medium {{ request()->routeIs('home') ? 'text-pink-600' : '' }}">
                        Inicio
                    </a>
                    <a href="{{ route('catalogo') }}"
                        class="text-gray-700 hover:text-pink-600 transition-colors font-medium {{ request()->routeIs('catalogo') ? 'text-pink-600' : '' }}">
                        Catálogo
                    </a>
                    <a href="{{ route('home') }}#nosotros" class="text-gray-700 hover:text-pink-600 transition-colors font-medium">
                        Nosotros
                    </a>
                    <a href="{{ route('home') }}#ubicacion" class="text-gray-700 hover:text-pink-600 transition-colors font-medium">
                        Ubicación
                    </a>
                    <a href="{{ route('home') }}#contacto" class="text-gray-700 hover:text-pink-600 transition-colors font-medium">
                        Contacto
                    </a>
                    <a href="{{ route('shop.tracking') }}" class="text-pink-600 hover:text-pink-800 transition-colors font-medium">
                        <i class="fas fa-search-location mr-1"></i> Rastrear
                    </a>

                    <!-- Ícono del carrito -->
                    @auth
                    {{-- Menú de usuario con dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden bg-pink-600">
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-full h-full object-cover">
                                @else
                                <span class="text-white font-bold text-sm">{{ auth()->user()->initials() }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open"
                            x-cloak
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">

                            {{-- Info del usuario --}}
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            @if(auth()->user()->hasRole('Cliente'))
                            <a href="{{ route('cliente.pedidos') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                <i class="fas fa-shopping-bag w-5 text-gray-400"></i> Mis Pedidos
                            </a>
                            <a href="{{ route('cliente.perfil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                <i class="fas fa-user w-5 text-gray-400"></i> Mi Perfil
                            </a>
                            @else
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                <i class="fas fa-tachometer-alt w-5 text-gray-400"></i> Panel Admin
                            </a>
                            <a href="{{ route('admin.pos.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                <i class="fas fa-cash-register w-5 text-gray-400"></i> Punto de Venta
                            </a>
                            @endif

                            <hr class="my-2">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-5"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 transition-colors font-medium">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors font-medium">
                        Registrarse
                    </a>
                    @endauth
                </div>

                <!-- Botón móvil + Carrito móvil -->
                <div class=" flex items-center space-x-3">
                    @livewire('shop.cart-icon')

                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-700 hover:text-pink-600 p-2 focus:outline-none rounded-lg hover:bg-gray-100 transition-colors"
                        type="button"
                        aria-label="Menú">
                        <i x-show="!mobileMenuOpen" class="fas fa-bars text-xl"></i>
                        <i x-show="mobileMenuOpen" x-cloak class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Móvil -->
        <div
            x-show="mobileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.away="mobileMenuOpen = false"
            class="md:hidden border-t border-gray-200 bg-white shadow-lg absolute w-full left-0">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                    class="block py-3 px-4 rounded-lg font-medium transition-colors {{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-home w-6"></i> Inicio
                </a>
                <a href="{{ route('catalogo') }}" @click="mobileMenuOpen = false"
                    class="block py-3 px-4 rounded-lg font-medium transition-colors {{ request()->routeIs('catalogo') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-store w-6"></i> Catálogo
                </a>
                <a href="{{ route('home') }}#nosotros" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    <i class="fas fa-info-circle w-6"></i> Nosotros
                </a>
                <a href="{{ route('home') }}#ubicacion" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    <i class="fas fa-map-marker-alt w-6"></i> Ubicación
                </a>
                <a href="{{ route('home') }}#contacto" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    <i class="fas fa-envelope w-6"></i> Contacto
                </a>
                <a href="{{ route('shop.tracking') }}" @click="mobileMenuOpen = false" class="block py-3 px-4 text-pink-600 hover:bg-pink-50 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search-location w-6"></i> Rastrear Pedido
                </a>

                <hr class="my-3">

                @auth
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 bg-pink-600 text-white rounded-lg text-center font-medium">
                    <i class="fas fa-tachometer-alt mr-2"></i>Panel Admin
                </a>
                @else
                <a href="{{ route('login') }}" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    <i class="fas fa-sign-in-alt w-6"></i> Iniciar Sesión
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- WhatsApp Flotante con animación -->
    <!-- WhatsApp Flotante Mejorado -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
        <!-- Tooltip -->
        <div class="bg-white px-4 py-2 rounded-xl shadow-lg border border-gray-100 hidden md:block animate-fade-in-up">
            <p class="text-sm font-semibold text-gray-800">¡Hola! 👋 ¿En qué podemos ayudarte?</p>
        </div>

        <!-- Botón -->
        <a href="https://wa.me/50245761805?text=Hola,%20me%20gustaría%20más%20información%20sobre%20sus%20productos%20personalizados"
            target="_blank"
            class="relative bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110 hover:shadow-green-500/30 group"
            aria-label="Contactar por WhatsApp">
            <!-- Ping animation wrapper -->
            <span class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75 animate-ping group-hover:hidden"></span>

            <i class="fab fa-whatsapp text-3xl z-10"></i>
        </a>
    </div>

    <!-- Contenido principal -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-purple-900 to-pink-900 text-white pt-16 pb-8 relative overflow-hidden">
        <!-- Decoracion fondo -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500"></div>
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Columna 1: Logo y descripción -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-white p-2 rounded-xl shadow-lg">
                            <img src="{{ asset('images/logo-tienda.png') }}" alt="Cariñitos GT" class="h-12 w-auto">
                        </div>
                        <div>
                            <span class="text-2xl font-bold text-white">Cariñitos</span><span class="text-2xl font-bold text-yellow-400">GT</span>
                            <span class="block text-xs text-pink-200 font-medium tracking-wider">Regalos Personalizados</span>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed max-w-sm">
                        Hacemos realidad tus ideas. Sublimación, bordados y regalos únicos para toda ocasión con el cariño que mereces.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/Siblimacion?locale=es_LA" target="_blank"
                            class="w-12 h-12 bg-white/10 hover:bg-blue-600 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110 border border-white/10"
                            aria-label="Facebook">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/carinitos.gt" target="_blank"
                            class="w-12 h-12 bg-white/10 hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110 border border-white/10"
                            aria-label="Instagram">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://wa.me/50245761805" target="_blank"
                            class="w-12 h-12 bg-white/10 hover:bg-green-500 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all hover:scale-110 border border-white/10"
                            aria-label="WhatsApp">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Columna 2: Enlaces -->
                <div>
                    <h3 class="text-lg font-bold mb-6 text-pink-200">Enlaces Rápidos</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white hover:translate-x-2 transition-all inline-block">Inicio</a></li>
                        <li><a href="{{ route('catalogo') }}" class="text-gray-300 hover:text-white hover:translate-x-2 transition-all inline-block">Catálogo</a></li>
                        <li><a href="{{ route('home') }}#nosotros" class="text-gray-300 hover:text-white hover:translate-x-2 transition-all inline-block">Nosotros</a></li>
                        <li><a href="{{ route('home') }}#ubicacion" class="text-gray-300 hover:text-white hover:translate-x-2 transition-all inline-block">Ubicación</a></li>
                        <li><a href="{{ route('home') }}#contacto" class="text-gray-300 hover:text-white hover:translate-x-2 transition-all inline-block">Contacto</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Contacto -->
                <div>
                    <h3 class="text-lg font-bold mb-6 text-pink-200">Contáctanos</h3>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 bg-green-500/20 p-2 rounded-lg">
                                <i class="fab fa-whatsapp text-green-400"></i>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">WhatsApp</span>
                                <a href="https://wa.me/50245761805" class="hover:text-white transition-colors font-medium">+502 4576 1805</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 bg-purple-500/20 p-2 rounded-lg">
                                <i class="fab fa-instagram text-purple-400"></i>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">Instagram</span>
                                <a href="https://www.instagram.com/carinitos.gt" target="_blank" class="hover:text-white transition-colors font-medium">@carinitos.gt</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 bg-pink-500/20 p-2 rounded-lg">
                                <i class="fas fa-envelope text-pink-400"></i>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">Email</span>
                                <a href="mailto:yezzdeleon92@gmail.com" class="hover:text-white transition-colors break-all text-sm">yezzdeleon92@gmail.com</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 bg-red-500/20 p-2 rounded-lg">
                                <i class="fas fa-map-marker-alt text-red-400"></i>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">Dirección</span>
                                <span>Campo Marte, Zona 5, Guatemala</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} <strong>Cariñitos GT</strong>. Todos los derechos reservados.
                    </p>
                    <div class="flex items-center space-x-2 text-sm text-gray-500 bg-white/5 px-4 py-2 rounded-full backdrop-blur-sm">
                        <i class="fas fa-heart text-red-500 animate-pulse"></i>
                        <span>Hecho con amor en Guatemala</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

    @stack('scripts')

    <!-- Catalog filters (solo se carga en la página del catálogo) -->
    @if(request()->routeIs('catalogo'))
    <script src="{{ asset('js/catalog-filters.js') }}"></script>
    @endif

    <!-- Script para smooth scroll y funcionalidad global del carrito -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Si la URL tiene un hash, hacer scroll suave después de cargar
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    setTimeout(() => {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            }
        });

        // Función global para agregar al carrito (disponible en todas las páginas)
        function addToCart(productId, quantity = 1, variants = {}, finalPrice = null) {
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('add-to-cart', {
                    productId: productId,
                    quantity: quantity,
                    variants: variants,
                    finalPrice: finalPrice
                });
            }
        }

        // Listener global para el evento cart-updated
        document.addEventListener('livewire:init', () => {
            Livewire.on('cart-updated', () => {
                const isMobile = window.innerWidth < 768;

                if (isMobile) {
                    showToast('✓ Producto agregado al carrito');
                } else {
                    Livewire.dispatch('open-cart');
                }
            });
        });

        // Función global de toast
        function showToast(message) {
            const existingToast = document.getElementById('cart-toast');
            if (existingToast) existingToast.remove();

            const toast = document.createElement('div');
            toast.id = 'cart-toast';
            toast.className = 'fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-xl shadow-2xl z-[9999] font-medium flex items-center gap-2';
            toast.innerHTML = '<i class="fas fa-check-circle"></i><span>' + message + '</span>';
            document.body.appendChild(toast);

            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, 20px)';
            requestAnimationFrame(() => {
                toast.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                toast.style.opacity = '1';
                toast.style.transform = 'translate(-50%, 0)';
            });

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, 20px)';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }
    </script>

</body>

</html>