@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es" x-data="{ mobileMenuOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Gallifer' }} - Agro-Tecnología</title>
    <link rel="icon" href="{{ asset('images/gallifer.jpeg') }}" type="image/x-icon">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Gallifer Agro-Tecnología - Soluciones integrales para agricultura, avicultura y ganadería en Guatemala.">
    <meta name="keywords" content="agricultura, avicultura, ganadería, fumigación, semillas, fertilizantes, guatemala, agro-tecnología">
    <meta name="author" content="Gallifer">

    <!-- Open Graph -->
    <meta property="og:title" content="Gallifer - Agro-Tecnología">
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
        :class="scrolled ? 'navbar-scrolled border-gray-100' : 'bg-white/95 backdrop-blur-md border-gray-200'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo - Gallifer -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative w-12 h-12 overflow-hidden rounded-xl shadow-md group-hover:shadow-lg transition-all duration-300">
                        <img src="{{ asset('images/gallifer.jpeg') }}" alt="Gallifer" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight text-primary-900">Gallifer</span>
                        <span class="block text-[10px] uppercase tracking-widest text-primary-600 font-semibold mt-0.5">Agro-Tecnología</span>
                    </div>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-sm font-semibold tracking-wide transition-colors {{ request()->routeIs('home') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">
                        INICIO
                    </a>
                    <a href="{{ route('catalogo') }}"
                        class="text-sm font-semibold tracking-wide transition-colors {{ request()->routeIs('catalogo') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">
                        CATÁLOGO
                    </a>
                    <a href="{{ route('home') }}#tecnologia" class="text-sm font-semibold tracking-wide text-gray-600 hover:text-primary-600 transition-colors">
                        TECNOLOGÍA
                    </a>
                    <a href="{{ route('home') }}#nosotros" class="text-sm font-semibold tracking-wide text-gray-600 hover:text-primary-600 transition-colors">
                        NOSOTROS
                    </a>
                    <a href="{{ route('home') }}#contacto" class="text-sm font-semibold tracking-wide text-gray-600 hover:text-primary-600 transition-colors">
                        CONTACTO
                    </a>

                    <!-- Ícono del carrito -->
                    <div class="hidden md:flex items-center mr-4">
                        <livewire:shop.cart-icon />
                    </div>

                    @auth
                    {{-- Menú de usuario con dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none border border-transparent hover:border-gray-200">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden bg-primary-700 text-white shadow-sm">
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-full h-full object-cover">
                                @else
                                <span class="font-bold text-xs">{{ auth()->user()->initials() }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open"
                            x-cloak
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 ring-1 ring-black ring-opacity-5">

                            {{-- Info del usuario --}}
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            @if(auth()->user()->hasRole('Cliente'))
                            <a href="{{ route('cliente.pedidos') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <i class="fas fa-shopping-bag w-5 text-gray-400 mr-2"></i> Mis Pedidos
                            </a>
                            <a href="{{ route('cliente.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <i class="fas fa-user w-5 text-gray-400 mr-2"></i> Mi Perfil
                            </a>
                            @else
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-2"></i> Panel Admin
                            </a>
                            <a href="{{ route('admin.pos.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <i class="fas fa-cash-register w-5 text-gray-400 mr-2"></i> Punto de Venta
                            </a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-700 text-sm font-semibold transition-colors">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition-all shadow-md hover:shadow-lg text-sm font-medium tracking-wide">
                            Registrarse
                        </a>
                    </div>
                    @endauth
                </div>

                <!-- Botón móvil + Carrito móvil -->
                <div class="flex md:hidden items-center space-x-4">
                    @livewire('shop.cart-icon')

                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-700 hover:text-primary-700 p-2 focus:outline-none rounded-lg hover:bg-gray-100 transition-colors"
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
            class="md:hidden border-t border-gray-200 bg-white shadow-lg absolute w-full left-0 z-50">
            <div class="px-4 py-6 space-y-2">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                    class="block py-3 px-4 rounded-lg font-medium transition-colors border-l-4 {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-800 border-primary-600' : 'text-gray-700 border-transparent hover:bg-gray-50' }}">
                    Inicio
                </a>
                <a href="{{ route('catalogo') }}" @click="mobileMenuOpen = false"
                    class="block py-3 px-4 rounded-lg font-medium transition-colors border-l-4 {{ request()->routeIs('catalogo') ? 'bg-primary-50 text-primary-800 border-primary-600' : 'text-gray-700 border-transparent hover:bg-gray-50' }}">
                    Catálogo
                </a>
                <a href="{{ route('home') }}#tecnologia" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    Tecnología
                </a>
                <a href="{{ route('home') }}#nosotros" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    Nosotros
                </a>
                <a href="{{ route('home') }}#contacto" @click="mobileMenuOpen = false" class="block py-3 px-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    Contacto
                </a>

                <hr class="my-4 border-gray-100">

                @auth
                <div class="px-4 py-2">
                    <p class="text-xs uppercase text-gray-400 font-bold tracking-wider mb-2">Mi Cuenta</p>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-sm text-primary-700 font-semibold">
                        <i class="fas fa-tachometer-alt mr-2"></i>Panel de Control
                    </a>
                </div>
                @else
                <div class="grid grid-cols-2 gap-4 px-4 pt-2">
                    <a href="{{ route('login') }}" class="flex items-center justify-center py-3 text-gray-700 hover:text-primary-700 font-semibold bg-gray-50 rounded-lg">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center py-3 bg-primary-700 text-white rounded-lg font-semibold shadow-md">
                        Registrarse
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- WhatsApp Flotante Mejorado (Agro Theme) -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
        <!-- Tooltip -->
        <div class="bg-white px-5 py-3 rounded-xl shadow-xl border border-gray-100 hidden md:block animate-fade-in-up">
            <p class="text-sm font-semibold text-gray-800">¿Necesita asesoría técnica?</p>
            <p class="text-xs text-primary-600 font-medium">Hable con un experto avícola</p>
        </div>

        <!-- Botón -->
        <a href="https://wa.me/50245761805?text=Hola,%20quisiera%20asesoría%20sobre%20productos%20avícolas"
            target="_blank"
            class="relative bg-emerald-500 hover:bg-emerald-600 text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-105 hover:shadow-emerald-500/40 group border-4 border-white"
            aria-label="Contactar por WhatsApp">
            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-30 animate-ping group-hover:hidden"></span>
            <i class="fab fa-whatsapp text-4xl z-10"></i>
        </a>
    </div>

    <!-- Contenido principal -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer - Professional Agro Theme -->
    <footer class="bg-slate-900 text-gray-300 relative overflow-hidden">
        <!-- Accent Line -->
        <div class="h-1 w-full bg-gradient-to-r from-primary-600 via-secondary-500 to-primary-600"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                <!-- Brand Info -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white p-1.5 rounded-lg">
                            <img src="{{ asset('images/gallifer.jpeg') }}" alt="Gallifer" class="h-10 w-10 object-cover rounded">
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">Gallifer</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Líderes en soluciones integrales para la industria avícola y ganadera. Innovación, tecnología y nutrición para maximizar su producción.
                    </p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Enlaces Rápidos</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Inicio</a></li>
                        <li><a href="{{ route('catalogo') }}" class="hover:text-primary-400 transition-colors">Catálogo de Productos</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Tecnología en Granjas</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Asesoría Técnica</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Contacto</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Oficina Central</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-500"></i>
                            <span>Campo Marte, Zona 5<br>Ciudad de Guatemala</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary-500"></i>
                            <span>+502 4576 1805</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-500"></i>
                            <a href="mailto:info@gallifer.com" class="hover:text-white">info@gallifer.com</a>
                        </li>
                    </ul>
                </div>

                <!-- Hours -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Horario de Atención</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between">
                            <span class="text-gray-400">Lunes - Viernes</span>
                            <span class="font-medium text-white">8:00 AM - 6:00 PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400">Sábado</span>
                            <span class="font-medium text-white">8:00 AM - 1:00 PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400">Domingo</span>
                            <span class="text-primary-400 font-medium">Cerrado</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Gallifer S.A. Todos los derechos reservados.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white">Política de Privacidad</a>
                    <a href="#" class="hover:text-white">Términos de Servicio</a>
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