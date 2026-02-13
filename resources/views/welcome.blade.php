<x-layouts.public>

    <!-- Hero Section Mejorado -->
    <section class="relative bg-gradient-to-br from-red-600 via-pink-600 to-rose-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

                <!-- Columna izquierda: Texto -->
                <div class="text-center lg:text-left">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-4">
                        <i class="fas fa-truck mr-2"></i>
                        Envíos a toda Guatemala
                    </div>

                    <!-- Título principal -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Cariñitos GT <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-100">
                            Regalos Personalizados
                        </span>
                    </h1>

                    <p class="text-xl sm:text-2xl text-rose-100 font-medium mb-6">
                        Sublimación, Bordados, Playeras y más.<br>¡Todo es personalizado!
                    </p>

                    <!-- Lista de beneficios -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-x-6 gap-y-2 mb-8 text-white">
                        <span class="flex items-center">
                            <i class="fas fa-check-circle text-yellow-300 mr-2"></i>
                            Diseños Únicos
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-check-circle text-yellow-300 mr-2"></i>
                            Alta Calidad
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-check-circle text-yellow-300 mr-2"></i>
                            Envíos a toda Guatemala
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-check-circle text-yellow-300 mr-2"></i>
                            Atención al cliente
                        </span>
                    </div>

                    <!-- CTAs principales -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8">
                        <a href="{{ route('catalogo') }}"
                            class="group px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-center">
                            <i class="fas fa-shopping-bag mr-2"></i>Ver Catálogo
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform inline-block"></i>
                        </a>
                        <a href="https://wa.me/50245761805?text=Hola,%20me%20interesa%20información%20sobre%20sus%20productos"
                            target="_blank"
                            class="px-8 py-4 bg-[#25D366] text-white rounded-xl font-bold text-lg hover:bg-[#20bd5a] hover:shadow-lg hover:shadow-green-500/30 transition-all duration-300 text-center flex items-center justify-center">
                            <i class="fab fa-whatsapp text-2xl mr-2"></i> Ordenar por WhatsApp
                        </a>
                    </div>

                    <!-- Beneficios en cards -->
                    <div class="grid grid-cols-4 gap-2 sm:gap-3">
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-white text-center">
                            <i class="fas fa-shipping-fast text-lg sm:text-xl mb-1"></i>
                            <p class="text-xs font-medium">Envío Rápido</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-white text-center">
                            <i class="fas fa-shield-alt text-lg sm:text-xl mb-1"></i>
                            <p class="text-xs font-medium">Pago Seguro</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-white text-center">
                            <i class="fas fa-headset text-lg sm:text-xl mb-1"></i>
                            <p class="text-xs font-medium">Soporte 24/7</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-white text-center">
                            <i class="fas fa-undo text-lg sm:text-xl mb-1"></i>
                            <p class="text-xs font-medium">Garantía</p>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: Visual Impactante (Sin logo) -->
                <div class="relative flex justify-center lg:justify-end mt-12 lg:mt-0 perspective-1000">
                    <div class="relative w-full max-w-md mx-auto transform-style-3d hover:rotate-y-12 transition-transform duration-500">

                        <!-- Círculos decorativos de fondo -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-yellow-400/20 rounded-full blur-2xl"></div>

                        <!-- Elemento Central: Caja de Regalo 3D / Icono Principal -->
                        <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl flex flex-col items-center justify-center text-center group z-20 hover:-translate-y-4 transition-transform duration-300">
                            <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-gift text-5xl text-white animate-bounce-slow"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">Regalos Únicos</h3>
                            <p class="text-pink-100 text-sm">Convertimos tus ideas en recuerdos inolvidables</p>

                            <!-- Boton simulado -->
                            <div class="mt-4 px-4 py-2 bg-white text-rose-600 rounded-full text-xs font-bold shadow-sm group-hover:shadow-md transition-all">
                                ¡Pide el tuyo!
                            </div>
                        </div>

                        <!-- Elementos Flotantes (Satélites) -->

                        <!-- Tarjeta 1: Playeras -->
                        <div class="absolute -top-12 -left-4 sm:-left-12 bg-white p-4 rounded-2xl shadow-xl z-30 animate-float-slow transform -rotate-6 transition-transform hover:scale-110 hover:rotate-0  duration-300 border-2 border-indigo-100 w-40">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Sublimación</p>
                                    <p class="text-sm font-bold text-gray-800">Playeras</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 2: Tazas -->
                        <div class="absolute -bottom-8 -right-4 sm:-right-8 bg-white p-4 rounded-2xl shadow-xl z-30 animate-float-medium transform rotate-3 transition-transform hover:scale-110 hover:rotate-0 duration-300 border-2 border-pink-100 w-40">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center text-pink-600">
                                    <i class="fas fa-mug-hot"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Personalizado</p>
                                    <p class="text-sm font-bold text-gray-800">Tazas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 3: Bordados -->
                        <div class="absolute top-1/2 -right-16 bg-white p-3 rounded-xl shadow-xl z-10 animate-float-fast hidden lg:block transform rotate-12 transition-transform hover:scale-110 hover:rotate-0 duration-300 border-2 border-yellow-100 w-36">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 mb-1">
                                    <i class="fas fa-hat-cowboy"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-800">Bordados</p>
                            </div>
                        </div>

                        <!-- Badge de Oferta -->
                        <div class="absolute -bottom-4 left-8 bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-full shadow-lg z-40 animate-pulse flex items-center gap-2 transform -rotate-3">
                            <i class="fas fa-percentage"></i>
                            <span class="font-bold">Descuentos Especiales</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Wave divider más pequeño -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-auto">
                <path d="M0 80L60 70C120 60 240 40 360 30C480 20 600 20 720 25C840 30 960 40 1080 45C1200 50 1320 50 1380 50L1440 50V80H1380C1320 80 1200 80 1080 80C960 80 840 80 720 80C600 80 480 80 360 80C240 80 120 80 60 80H0Z" fill="white" />
            </svg>
        </div>
    </section>

    <!-- Sección de Ofertas -->
    @include('partials.offers_section')

    <!-- Productos Destacados - 6 productos, cards más pequeños -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <div class="text-center sm:text-left mb-4 sm:mb-0">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">
                        <i class="fas fa-fire text-orange-500 mr-2"></i>Productos Destacados
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">Descubre los favoritos de nuestros clientes</p>
                </div>
                <a href="{{ route('catalogo') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center text-sm group">
                    Ver todos <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            @php
            $featuredProducts = App\Models\Product::with(['category', 'brand'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();
            @endphp

            @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">
                @foreach($featuredProducts as $product)
                <a href="{{ route('catalogo') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 card-hover">
                    <!-- Imagen optimizada -->
                    <div class="relative aspect-square bg-gray-50 overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 img-optimized">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <i class="fas fa-box text-gray-300 text-3xl"></i>
                        </div>
                        @endif

                        @if($product->created_at->diffInDays() < 7)
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow">
                            NUEVO
                            </span>
                            @endif
                    </div>

                    <!-- Info compacta -->
                    <div class="p-2.5">
                        @if($product->category)
                        <span class="text-[10px] font-medium text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">
                            {{ Str::limit($product->category->name, 12) }}
                        </span>
                        @endif

                        <h3 class="font-semibold text-gray-900 text-xs sm:text-sm mt-1.5 mb-1 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors h-8">
                            {{ Str::limit($product->name, 30) }}
                        </h3>

                        <div class="flex items-center justify-between">
                            <span class="text-base sm:text-lg font-bold text-indigo-600">
                                Q{{ number_format($product->precio_venta, 0) }}
                            </span>
                            <span class="text-[10px] text-green-600 font-medium">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Botón ver catálogo -->
            <div class="text-center">
                <a href="{{ route('catalogo') }}"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 hover:shadow-lg transition-all group">
                    <i class="fas fa-th-large mr-2"></i>Ver Catálogo Completo
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-2xl">
                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                <p class="text-lg text-gray-600">Próximamente más productos</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Nosotros - Vibrante -->
    <section id="nosotros" class="py-20 relative overflow-hidden bg-rose-50 scroll-mt-20">
        <!-- Elementos decorativos de fondo -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-rose-100/50 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Imagen/Visual Creativo (Sin logo repetitivo) -->
                <div class="relative order-2 lg:order-1">
                    <div class="relative z-10 grid grid-cols-2 gap-4">
                        <div class="space-y-4 mt-8">
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-heart text-3xl mb-3"></i>
                                <h3 class="font-bold text-lg">Amor en cada detalle</h3>
                            </div>
                            <div class="bg-white rounded-2xl p-6 shadow-lg text-gray-800">
                                <span class="block text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-600 mb-1">500+</span>
                                <span class="text-sm font-medium text-gray-500">Clientes Felices</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white rounded-2xl p-6 shadow-lg text-gray-800">
                                <span class="block text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-600 mb-1">100%</span>
                                <span class="text-sm font-medium text-gray-500">Personalizado</span>
                            </div>
                            <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl p-6 text-white shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-shipping-fast text-3xl mb-3"></i>
                                <h3 class="font-bold text-lg">Envío Rápido</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Decoración extra -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40 animate-blob"></div>
                </div>

                <!-- Texto -->
                <div class="order-1 lg:order-2">
                    <div class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold mb-4">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>Sobre Nosotros
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mt-2 mb-6 leading-tight">
                        Detalles que <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-indigo-600">enamoran</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        En <strong class="text-indigo-600">Cariñitos GT</strong> no solo vendemos productos, creamos sonrisas. Nos especializamos en transformar tus ideas en regalos únicos con sublimación y bordados de la más alta calidad.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Ya sea una taza para el café de la mañana, una playera para tu equipo o un detalle especial para esa persona favorita, nosotros lo hacemos posible.
                    </p>

                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full bg-red-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">A</div>
                            <div class="w-10 h-10 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">C</div>
                            <div class="w-10 h-10 rounded-full bg-green-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">J</div>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Únete a nuestros clientes satisfechos</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ubicación -->
    <section id="ubicacion" class="py-16 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Encuéntranos</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">
                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>Nuestra Ubicación
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Mapa -->
                <div class="rounded-2xl overflow-hidden shadow-lg h-72 lg:h-80">
                    <iframe
                        src="https://maps.google.com/maps?q=14.63739,-90.52447&z=15&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Ubicación de Cariñitos GT">
                    </iframe>
                </div>

                <!-- Info de contacto -->
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl shadow-lg p-6 border border-indigo-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-300 rounded-bl-full opacity-20"></div>

                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center mr-3">
                            <i class="fas fa-address-card text-white text-sm"></i>
                        </span>
                        Información de Contacto
                    </h3>

                    <div class="space-y-5">
                        <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-white hover:shadow-sm transition-all">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 text-red-500">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Dirección</h4>
                                <p class="text-gray-600 text-sm">13 calle A 2-80 zona 3 ciudad capital</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-white hover:shadow-sm transition-all">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0 text-green-500">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">WhatsApp</h4>
                                <a href="https://wa.me/50245761805" class="text-green-600 hover:text-green-700 font-bold hover:underline">+502 4576 1805</a>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-white hover:shadow-sm transition-all">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0 text-indigo-500">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Email</h4>
                                <a href="mailto:yezzdeleon92@gmail.com" class="text-indigo-600 hover:text-indigo-700 font-medium hover:underline text-sm">yezzdeleon92@gmail.com</a>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-white hover:shadow-sm transition-all">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0 text-yellow-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Horario</h4>
                                <p class="text-gray-600 text-sm">Lun - Sáb: 8:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de navegación -->
                    <div class="grid grid-cols-2 gap-3 mt-8">
                        <a href="https://waze.com/ul?ll=14.63739,-90.52447&navigate=yes"
                            target="_blank"
                            class="flex items-center justify-center px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-bold transition-all hover:shadow-lg hover:-translate-y-0.5 text-sm group">
                            <i class="fab fa-waze mr-2 text-lg group-hover:animate-bounce"></i>Waze
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=14.63739,-90.52447"
                            target="_blank"
                            class="flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold transition-all hover:shadow-lg hover:-translate-y-0.5 text-sm group">
                            <i class="fab fa-google mr-2 text-lg group-hover:animate-bounce"></i>Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-20 bg-gradient-to-b from-white to-indigo-50 scroll-mt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-pink-100 text-pink-700 rounded-full text-sm font-bold mb-4 animate-bounce">
                    ¿Dudas?
                </span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2">
                    Hablemos de tu próximo regalo
                </h2>
                <p class="text-gray-500 mt-4 text-lg">Estamos listos para atenderte por cualquiera de estos medios</p>
            </div>

            <!-- Opciones de contacto rápido -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- WhatsApp Card (Destacada) -->
                <a href="https://wa.me/50245761805?text=Hola,%20tengo%20una%20consulta"
                    target="_blank"
                    class="relative group bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-8 text-center transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-2 overflow-hidden col-span-1 md:col-span-3 lg:col-span-1 lg:row-span-2 flex flex-col justify-center items-center">

                    <!-- Decoración flotante -->
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fab fa-whatsapp text-9xl text-white transform rotate-12 translate-x-8 -translate-y-8"></i>
                    </div>

                    <div class="relative z-10 w-full">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <i class="fab fa-whatsapp text-5xl text-white"></i>
                        </div>
                        <h3 class="font-bold text-white text-2xl mb-2">WhatsApp</h3>
                        <p class="text-green-50 font-medium mb-6 text-lg tracking-wide">+502 4576 1805</p>
                        <span class="inline-block w-full bg-white text-green-700 px-6 py-3 rounded-xl font-bold text-sm shadow-md group-hover:shadow-lg transition-all transform group-hover:scale-105">
                            Chat Inmediato <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </span>
                    </div>
                </a>

                <!-- Instagram (Nuevo) -->
                <a href="https://www.instagram.com/carinitos.gt"
                    target="_blank"
                    class="relative group bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 rounded-2xl p-8 text-center transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-2 overflow-hidden flex flex-col justify-center items-center">
                    
                    <!-- Decoración -->
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fab fa-instagram text-9xl text-white transform rotate-12 translate-x-8 -translate-y-8"></i>
                    </div>

                    <div class="relative z-10 w-full">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <i class="fab fa-instagram text-4xl text-white"></i>
                        </div>
                        <h3 class="font-bold text-white text-xl mb-1">Instagram</h3>
                        <p class="text-pink-100 text-sm mb-4">@carinitos.gt</p>
                        <span class="inline-block px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg text-sm font-bold transition-colors">
                            Ver Fotos
                        </span>
                    </div>
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/Siblimacion?locale=es_LA"
                    target="_blank"
                    class="group bg-white hover:bg-blue-600 rounded-2xl p-8 text-center transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-2 border border-blue-50 hover:border-blue-600">
                    <div class="w-16 h-16 bg-blue-50 group-hover:bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors">
                        <i class="fab fa-facebook text-3xl text-blue-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-white text-xl transition-colors">Facebook</h3>
                    <p class="text-sm text-gray-500 group-hover:text-blue-100 transition-colors mt-2">Síguenos para ver novedades</p>
                </a>

                <!-- Email -->
                <a href="mailto:yezzdeleon92@gmail.com"
                    class="group bg-white hover:bg-indigo-600 rounded-2xl p-8 text-center transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-2 border border-indigo-50 hover:border-indigo-600">
                    <div class="w-16 h-16 bg-indigo-50 group-hover:bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors">
                        <i class="fas fa-envelope text-3xl text-indigo-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-white text-xl transition-colors">Email</h3>
                    <p class="text-sm text-gray-500 group-hover:text-indigo-100 transition-colors mt-2">Escríbenos tu consulta</p>
                </a>
            </div>
        </div>
    </section>



</x-layouts.public>