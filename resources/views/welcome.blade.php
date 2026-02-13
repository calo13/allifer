<x-layouts.public>

    <!-- HERO SECTION -->
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);">
        <!-- Overlay Pattern -->
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/ag-square.png');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/90 via-transparent to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col lg:flex-row items-center">

            <!-- Content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left z-10 mb-12 lg:mb-0">
                <span class="inline-block py-1 px-3 rounded-full bg-secondary-500/20 text-secondary-400 border border-secondary-500/30 text-sm font-bold tracking-wider mb-6 animate-fade-in-up"
                    style="color: #fbbf24; background-color: rgba(251, 191, 36, 0.2); border-color: rgba(251, 191, 36, 0.3);">
                    <i class="fas fa-seedling mr-2"></i> SOLUCIONES AGROPECUARIAS INTEGRALES
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 tracking-tight">
                    Impulsando tu <br>
                    <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(to right, #fbbf24, #fef08a); -webkit-background-clip: text; color: transparent;">
                        Producción Agrícola
                    </span>
                </h1>

                <p class="text-lg sm:text-xl text-gray-300 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-light">
                    Desde semillas de alto rendimiento y equipos de fumigación hasta nutrición avícola. Todo lo necesario para maximizar tu cosecha y producción.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('catalogo') }}" class="group px-8 py-4 bg-secondary-500 hover:bg-secondary-400 text-primary-900 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-secondary-500/30 transform hover:-translate-y-1 transition-all duration-300 text-center w-full sm:w-auto flex items-center justify-center"
                        style="background-color: #fbbf24; color: #064e3b;">
                        <i class="fas fa-tractor mr-2 opacity-80"></i> Ver Catálogo
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform inline-block"></i>
                    </a>
                    <a href="https://wa.me/50245761805" target="_blank" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-xl font-bold text-lg hover:bg-white/20 transition-all duration-300 text-center w-full sm:w-auto flex items-center justify-center">
                        <i class="fab fa-whatsapp text-2xl mr-2 text-emerald-400"></i> Contactar Asesor
                    </a>
                </div>

                <!-- Stats/Trust -->
                <div class="mt-12 flex flex-wrap justify-center lg:justify-start gap-8 text-gray-400 text-sm font-medium">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-secondary-500 mr-2"></i> Envíos a todo el país
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-secondary-500 mr-2"></i> Asesoría Técnica
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-secondary-500 mr-2"></i> Calidad Garantizada
                    </div>
                </div>
            </div>

            <!-- Visual Element (Cards/Image) -->
            <div class="w-full lg:w-1/2 relative z-10 lg:pl-12">
                <div class="relative grid grid-cols-2 gap-4">
                    <!-- Card 1: Fumigación -->
                    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-2xl transform translate-y-8 animate-float-slow border border-white/20">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 text-blue-600">
                            <i class="fas fa-spray-can text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-1">Fumigación</h3>
                        <p class="text-xs text-gray-600">Equipos manuales y motorizados de alta eficiencia.</p>
                    </div>

                    <!-- Card 2: Semillas -->
                    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-2xl transform -translate-y-4 animate-float-delayed border border-white/20">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-600">
                            <i class="fas fa-seedling text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-1">Semillas</h3>
                        <p class="text-xs text-gray-600">Variedades certificadas para máximo rendimiento.</p>
                    </div>

                    <!-- Card 3: Avícola -->
                    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-2xl col-span-2 mx-auto w-2/3 transform -translate-y-12 z-20 animate-float border border-white/20">
                        <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mb-4 text-yellow-600 mx-auto">
                            <i class="fas fa-egg text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-1 text-center">Avicultura</h3>
                        <p class="text-xs text-gray-600 text-center">Incubadoras, alimento y medicina.</p>
                    </div>
                </div>

                <!-- Decorative Circles -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-secondary-500/20 rounded-full blur-3xl -z-10 animate-pulse-slow"></div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="fill-current text-white w-full h-auto">
                <path d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,85.3C672,75,768,85,864,96C960,107,1056,117,1152,112C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Categorías Principales (Pillars) -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <!-- Header Section -->
                <div class="text-center mb-16 relative">
                    <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 border border-orange-200 text-sm font-bold tracking-wider mb-4 animate-fade-in-up uppercase">
                        Catálogo Especializado
                    </span>
                    <h2 class="text-primary-900 font-extrabold text-3xl sm:text-5xl mb-6 tracking-tight leading-tight">
                        Todo para su <span class="text-secondary-600">Ciclo Productivo</span>
                    </h2>
                    <div class="h-1.5 w-24 bg-gradient-to-r from-primary-500 to-secondary-500 mx-auto rounded-full mb-6"></div>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto font-light">
                        Soluciones certificadas para agricultura, avicultura y el cuidado integral de sus mascotas.
                    </p>
                </div>

                <!-- Grid de Categorías -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Card 1: Agricultura (Semillas y Fertilizantes) -->
                    <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-green-100/50 rounded-bl-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-green-200 group-hover:-translate-y-2 transition-transform duration-300"
                                style="background: linear-gradient(135deg, #4ade80 0%, #059669 100%); box-shadow: 0 10px 15px -3px rgba(74, 222, 128, 0.4);">
                                <i class="fas fa-seedling text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors" style="color: #16a34a;">Agricultura</h3>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                                Semillas certificadas, fertilizantes foliares y edáficos para potenciar sus cultivos.
                            </p>
                            <ul class="mb-6 space-y-2 text-sm text-gray-600">
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Semillas Híbridas</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Fertilizantes NPK</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Estimulantes</li>
                            </ul>
                            <a href="{{ route('catalogo') }}?categoria=agricultura" class="inline-flex items-center text-green-600 font-bold tracking-wide group-hover:underline decoration-2 underline-offset-4">
                                Ver Productos <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Mascotas (Vacunación y Desparasitación) -->
                    <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-orange-100/50 rounded-bl-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-orange-200 group-hover:-translate-y-2 transition-transform duration-300"
                                style="background: linear-gradient(135deg, #fb923c 0%, #ef4444 100%); box-shadow: 0 10px 15px -3px rgba(251, 146, 60, 0.4);">
                                <i class="fas fa-paw text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors" style="color: #ea580c;">Mascotas</h3>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                                Salud y bienestar para sus compañeros. Vacunas, desparasitantes y vitaminas.
                            </p>
                            <ul class="mb-6 space-y-2 text-sm text-gray-600">
                                <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i> Vacunación Completa</li>
                                <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i> Desparasitantes</li>
                                <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i> Suplementos</li>
                            </ul>
                            <a href="{{ route('catalogo') }}?categoria=mascotas" class="inline-flex items-center text-orange-600 font-bold tracking-wide group-hover:underline decoration-2 underline-offset-4">
                                Cuidado Animal <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Avicultura (Incubación y Equipos) -->
                    <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-yellow-100/50 rounded-bl-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-amber-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-yellow-200 group-hover:-translate-y-2 transition-transform duration-300"
                                style="background: linear-gradient(135deg, #facc15 0%, #d97706 100%); box-shadow: 0 10px 15px -3px rgba(250, 204, 21, 0.4);">
                                <i class="fas fa-egg text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors" style="color: #ca8a04;">Avicultura</h3>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                                Equipamiento profesional para incubación y crianza. Tecnología para su granja.
                            </p>
                            <ul class="mb-6 space-y-2 text-sm text-gray-600">
                                <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i> Incubadoras</li>
                                <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i> Comederos/Bebederos</li>
                                <li class="flex items-center"><i class="fas fa-check text-yellow-500 mr-2"></i> Medicina Aviar</li>
                            </ul>
                            <a href="{{ route('catalogo') }}?categoria=avicultura" class="inline-flex items-center text-yellow-600 font-bold tracking-wide group-hover:underline decoration-2 underline-offset-4">
                                Ver Equipos <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4: Fumigación & Control -->
                    <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 relative overflow-hidden lg:col-span-3 flex flex-col md:flex-row items-center gap-8">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-100/50 rounded-bl-full -mr-32 -mt-32 group-hover:scale-110 transition-transform duration-500"></div>

                        <div class="w-full md:w-1/3 flex justify-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-xl shadow-blue-200 group-hover:scale-110 transition-transform duration-300"
                                style="background: linear-gradient(135deg, #60a5fa 0%, #4f46e5 100%); box-shadow: 0 10px 15px -3px rgba(96, 165, 250, 0.4);">
                                <i class="fas fa-spray-can text-5xl"></i>
                            </div>
                        </div>

                        <div class="w-full md:w-2/3 text-center md:text-left relative z-10">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors" style="color: #2563eb;">Fumigación y Control de Plagas</h3>
                            <p class="text-gray-500 text-lg mb-6 leading-relaxed">
                                Proteja su inversión con nuestra línea completa de bombas de mochila, motorizadas y equipos de nebulización. Soluciones efectivas para todo tipo de cultivo e instalaciones.
                            </p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-100">Bombas Manuales</span>
                                <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-100">Motorizadas</span>
                                <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-100">Repuestos</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>

    <!-- Tecnología e Innovación -->
    <section id="tecnologia" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')] opacity-5"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1586771107445-d3ca888129ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Tecnología en Granja" class="w-full h-auto object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-900/80 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-xs font-mono uppercase text-green-400">Sistema Activo</span>
                            </div>
                            <p class="font-bold text-lg">Monitoreo en Tiempo Real</p>
                        </div>
                    </div>
                    <!-- Floater Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-xl max-w-xs border border-gray-100 hidden lg:block">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-10 h-10 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Eficiencia</p>
                                <p class="text-lg font-bold text-primary-900">+35% Producción</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 italic">"La implementación de sensores redujo la mortalidad en un 15%."</p>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <span class="text-secondary-600 font-bold uppercase tracking-wider text-sm mb-2 block">Agro-Tecnología 4.0</span>
                    <h2 class="text-4xl font-extrabold text-primary-900 mb-6 leading-tight">
                        Transforme su Granja en una <span class="text-secondary-600">Empresa Inteligente</span>
                    </h2>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Implementamos soluciones tecnológicas que le permiten tomar decisiones basadas en datos, no en suposiciones. Automatice procesos, controle ambientes y maximice su rentabilidad.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center text-primary-700 mt-1">
                                <i class="fas fa-temperature-high text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Control Ambiental</h4>
                                <p class="text-gray-500 text-sm mt-1">Sensores de temperatura y humedad que activan ventilación automáticamente.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-secondary-50 flex items-center justify-center text-secondary-600 mt-1">
                                <i class="fas fa-mobile-alt text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Gestión Remota</h4>
                                <p class="text-gray-500 text-sm mt-1">Monitoree su granja desde su celular en cualquier lugar del mundo.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 mt-1">
                                <i class="fas fa-shield-virus text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Bioseguridad Inteligente</h4>
                                <p class="text-gray-500 text-sm mt-1">Sistemas de trazabilidad y control de acceso para prevenir enfermedades.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Destacados / Ofertas -->
    @include('partials.offers_section')

    <!-- Trust & Stats -->
    <section class="py-20 bg-primary-900 relative">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-white font-bold text-3xl mb-4">Aliados de las Mejores Marcas</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Trabajamos únicamente con proveedores certificados mundialmente para garantizar la calidad en su producción.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Logos placeholders (usando texto estilizado por ahora) -->
                <div class="h-20 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-white font-bold text-xl tracking-widest">AVIPRO</span>
                </div>
                <div class="h-20 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-white font-bold text-xl tracking-widest">TECHNO</span>
                </div>
                <div class="h-20 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-white font-bold text-xl tracking-widest">NUTRI</span>
                </div>
                <div class="h-20 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-white font-bold text-xl tracking-widest">VETMED</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Ubicación y Contacto Clean -->
    <section id="contacto" class="py-0 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="bg-gray-100 h-96 lg:h-auto min-h-[500px] relative">
                <iframe
                    src="https://maps.google.com/maps?q=14.63739,-90.52447&z=15&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    class="absolute inset-0 grayscale hover:grayscale-0 transition-all duration-500">
                </iframe>
            </div>
            <div class="bg-white p-12 lg:p-20 flex flex-col justify-center">
                <span class="text-secondary-600 font-bold uppercase tracking-wider text-sm mb-2">Contáctenos</span>
                <h2 class="text-3xl font-extrabold text-primary-900 mb-6">Visite nuestra Sede Central</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Nuestros ingenieros y veterinarios están listos para atenderle. Contamos con sala de ventas y showroom de equipos.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-secondary-500 text-xl mt-1 w-8"></i>
                        <div>
                            <h4 class="font-bold text-gray-900">Dirección</h4>
                            <p class="text-gray-500 text-sm">Campo Marte, Zona 5, Ciudad de Guatemala</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-phone-alt text-secondary-500 text-xl mt-1 w-8"></i>
                        <div>
                            <h4 class="font-bold text-gray-900">Teléfono y WhatsApp</h4>
                            <p class="text-gray-500 text-sm">+502 4576 1805</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-secondary-500 text-xl mt-1 w-8"></i>
                        <div>
                            <h4 class="font-bold text-gray-900">Correo Electrónico</h4>
                            <p class="text-gray-500 text-sm">info@gallifer.com</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="https://wa.me/50245761805" target="_blank" class="inline-block w-full text-center bg-primary-700 text-white font-bold py-4 rounded-xl hover:bg-primary-800 transition-colors shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i> Chatear con Ventas
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>