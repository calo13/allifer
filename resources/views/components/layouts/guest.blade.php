<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="bg-gray-50 font-sans">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <!-- Logo y título -->
            <div class="text-center">
                <!-- Usando tu logo personalizado -->
                <div class="mx-auto mb-6 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl blur-xl opacity-50"></div>
                        <img src="{{ asset('images/logo-tienda.png') }}" 
                             alt="Tienda Virtual" 
                             class="relative h-28 w-auto p-4 bg-white rounded-3xl shadow-2xl">
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Tienda Virtual</h2>
                <p class="mt-2 text-sm text-gray-600">Sistema de Gestión Empresarial</p>
            </div>

            <!-- Contenido -->
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <p class="text-center text-xs text-gray-500">
                © {{ date('Y') }} Procode Innovations - Todos los derechos reservados
            </p>
        </div>
    </div>

    @livewireScripts
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>