<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} - Tienda Virtual</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        // Apply theme immediately to prevent FOUC
        const savedTheme = localStorage.getItem('theme') || 'theme-indigo';
        document.documentElement.className = savedTheme;
    </script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false, sidebarDesktopOpen: true }">

        <!-- Overlay para móvil -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'lg:hidden': !sidebarDesktopOpen, 'lg:block': sidebarDesktopOpen }"
            class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">

            <!-- Logo -->
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Tienda Virtual</h1>
                </div>
                <!-- Botón cerrar en móvil -->
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="mt-6 pb-6">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-home w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Inventario Section -->
                <div class="mt-6 px-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Inventario</h3>
                </div>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-box w-5 mr-3"></i>
                    <span>Productos</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-tags w-5 mr-3"></i>
                    <span>Categorías</span>
                </a>

                <a href="{{ route('admin.brands.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-copyright w-5 mr-3"></i>
                    <span>Marcas</span>
                </a>

                <a href="{{ route('admin.suppliers.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.suppliers.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-truck w-5 mr-3"></i>
                    <span>Proveedores</span>
                </a>

                <!-- Control de Stock -->
                <a href="{{ route('admin.stock-control.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.stock-control.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-chart-line w-5 mr-3"></i>
                    <span>Control de Stock</span>
                </a>

                <!-- Marketing Section -->
                <div class="mt-6 px-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Marketing</h3>
                </div>

                <a href="{{ route('admin.promotions.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.promotions.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-percent w-5 mr-3"></i>
                    <span>Promociones</span>
                </a>

                <!-- Pedidos Section -->
                <div class="mt-6 px-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pedidos Online</h3>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-dolly w-5 mr-3"></i>
                    <span>Administrar Pedidos</span>
                </a>

                <!-- Ventas Section -->
                <div class="mt-6 px-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Ventas</h3>
                </div>

                <a href="{{ route('admin.pos.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.pos.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-cash-register w-5 mr-3"></i>
                    <span>Punto de Venta</span>
                </a>

                <a href="{{ route('admin.sales.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.sales.index') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-shopping-bag w-5 mr-3"></i>
                    <span>Historial de Ventas</span>
                </a>

                <a href="{{ route('admin.sales.report') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.sales.report') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-chart-pie w-5 mr-3"></i>
                    <span>Reporte Contable</span>
                </a>

                <a href="{{ route('admin.cash-report') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.cash-report') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-cash-register w-5 mr-3"></i>
                    <span>Reporte de Caja</span>
                </a>

                <!-- Otros -->
                <div class="mt-6 px-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Otros</h3>
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>Usuarios</span>
                </a>

                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                    <i class="fas fa-user-friends w-5 mr-3"></i>
                    <span>Clientes</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 sm:px-6 py-4">

                    <div class="flex items-center">
                        <!-- Botón hamburguesa (móvil y desktop) -->
                        <button @click="window.innerWidth >= 1024 ? sidebarDesktopOpen = !sidebarDesktopOpen : sidebarOpen = true"
                            class="text-gray-500 hover:text-gray-700 mr-4 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Panel de Administración</h2>
                    </div>


                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Theme Switcher -->
                        <div x-data="{ 
                            themeOpen: false, 
                            currentTheme: localStorage.getItem('theme') || 'theme-indigo',
                            themes: [
                                { name: 'Indigo', class: 'theme-indigo', color: 'bg-indigo-500' },
                                { name: 'Emerald', class: 'theme-emerald', color: 'bg-emerald-500' },
                                { name: 'Rose', class: 'theme-rose', color: 'bg-rose-500' },
                                { name: 'Blue', class: 'theme-blue', color: 'bg-blue-500' },
                                { name: 'Amber', class: 'theme-amber', color: 'bg-amber-500' },
                                { name: 'Slate', class: 'theme-slate', color: 'bg-slate-500' },
                            ],
                            setTheme(val) {
                                this.currentTheme = val;
                                localStorage.setItem('theme', val);
                                document.documentElement.className = val;
                                this.themeOpen = false;
                            }
                        }" class="relative">
                            <button @click="themeOpen = !themeOpen" @click.away="themeOpen = false" class="p-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none" title="Personalizar Tema">
                                <i class="fas fa-palette text-lg"></i>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="themeOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 z-50 p-2 grid grid-cols-3 gap-2"
                                style="display: none;">

                                <template x-for="theme in themes">
                                    <button @click="setTheme(theme.class)"
                                        class="w-10 h-10 rounded-full flex items-center justify-center transition-transform hover:scale-110 focus:outline-none ring-2 ring-transparent ring-offset-2"
                                        :class="currentTheme === theme.class ? 'ring-gray-400' : ''"
                                        :title="theme.name">
                                        <span class="w-8 h-8 rounded-full" :class="theme.color"></span>
                                        <i x-show="currentTheme === theme.class" class="fas fa-check text-white text-xs absolute"></i>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <livewire:admin.notifications />

                        <div class="h-6 w-px bg-gray-300 hidden sm:block"></div>

                        <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                            <i class="fas fa-store mr-2"></i>
                            Ir a la Tienda
                        </a>

                        <div class="hidden sm:flex items-center space-x-2">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </div>

                        <div class="h-6 w-px bg-gray-300 hidden sm:block"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-2 sm:px-3 py-2 text-xs sm:text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors">
                                <i class="fas fa-sign-out-alt sm:mr-2"></i>
                                <span class="hidden sm:inline">Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    @stack('scripts')
</body>

</html>