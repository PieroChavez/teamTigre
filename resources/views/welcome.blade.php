<x-guest-layout>

    
    {{-- ************************************************* --}}
    {{-- 1. SECCIÓN DE PORTADA (Imagen desplazada a la izquierda) --}}
    {{-- ************************************************* --}}
    <div class="relative bg-black overflow-hidden border-b border-orange-500/20 pt-16"> 
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-black sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                
                {{-- División futurista --}}
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-black transform translate-x-1/2"
                     fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">

                        {{-- TÍTULO --}}
                        <h1 class="text-6xl tracking-tighter font-black text-white sm:text-7xl md:text-8xl animate-fadeInUp">
                            <span class="block">FORJA TU LEYENDA EN</span>
                            <span class="block bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-red-500 mt-2">
                                EL TIGRE
                            </span>
                        </h1>

                        {{-- DESCRIPCIÓN --}}
                        <p class="mt-5 text-xl text-gray-400 sm:mt-7 sm:text-2xl sm:max-w-xl sm:mx-auto md:mt-8 lg:mx-0 font-medium animate-fadeInUp delay-300">
                            Dominio, disciplina y poder. El entrenamiento de élite que te convierte en un campeón, desde cero hasta el ring profesional.
                        </p>

                        {{-- BOTONES --}}
                        <div class="mt-8 sm:mt-12 sm:flex sm:justify-center lg:justify-start gap-4 animate-fadeInUp delay-500">
                            <a href="{{ route('planes') }}"
                               class="px-10 py-4 font-extrabold rounded-lg bg-orange-500 text-black hover:bg-orange-400
                                      transition transform hover:scale-[1.03] shadow-orange-500/50 shadow-xl">
                                ¡ENTRENAR AHORA!
                            </a>

                            <a href="{{ route('login') }}"
                               class="px-10 py-4 font-medium rounded-lg border border-orange-500 text-orange-400
                                      hover:bg-gray-800 transition">
                                Ya soy Alumno
                            </a>
                        </div>

                    </div>
                </main>
            </div>
        </div>

        {{-- IMAGEN DE PORTADA --}}
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 overflow-hidden">
            
            {{-- Overlay oscuro --}}
            <div class="absolute inset-0 bg-black/50 z-10"></div>

            <img
                src="{{ asset('img/portada.png') }}"
                alt="Entrenamiento de boxeo - Escuela de Box El Tigre"
                class="h-56 w-full sm:h-72 md:h-96 lg:h-full lg:w-full
                       object-cover object-[20%_center]
                       transition duration-700 ease-in-out hover:scale-110">
        </div>
    </div>
    
    {{-- ************************************************* --}}
    {{-- 2. SECCIÓN: PLANES DE PRECIOS (Dinámicos - Estilo PREMIUM) --}}
    {{-- ************************************************* --}}
    <div class="py-20 bg-gray-900 border-t border-orange-500/10"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-xl text-orange-400 font-extrabold tracking-widest uppercase">INSCRÍBETE</h2>
                <p class="mt-2 text-4xl leading-tight font-black tracking-tight text-white sm:text-5xl">
                    NIVELES DE DOMINIO
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-12 md:grid-cols-3 lg:gap-16">
                
                @forelse ($plans as $plan)
                    {{-- Tarjeta con Borde y Sombra de élite --}}
                    <div class="p-1 border-4 rounded-xl shadow-2xl transition duration-500 transform hover:scale-[1.05] 
                        {{ $loop->iteration == 2 ? 'border-orange-500 bg-gray-900 shadow-orange-900/50 relative' : 'border-gray-800 bg-gray-800/70 hover:bg-gray-800' }}">
                        
                        <div class="p-8 bg-gray-900 rounded-lg h-full flex flex-col justify-between">
                            
                            @if ($loop->iteration == 2)
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 px-4 py-1.5 bg-orange-600 text-sm font-black tracking-widest rounded-full shadow-lg text-white transform rotate-3 z-10">
                                    ÉLITE
                                </div>
                            @endif

                            <div>
                                <h3 class="text-4xl font-black mb-1 text-white uppercase">{{ $plan->name }}</h3>
                                <p class="text-sm text-orange-400 mb-8 font-semibold">{{ $plan->duration_days }} DÍAS DE LUCHA</p>

                                <div class="text-6xl font-black mb-8">
                                    <span class="text-orange-500">S/{{ number_format($plan->price, 0) }}</span>
                                    <span class="text-gray-400 text-xl font-normal">/{{ $plan->duration_days == 30 ? 'MES' : 'PERÍODO' }}</span>
                                </div>

                                {{-- Características --}}
                                <ul class="text-left space-y-4 mb-10 text-gray-300">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-orange-500 mr-3 mt-1 text-lg"></i> <span>Acceso Ilimitado al Dojo.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-orange-500 mr-3 mt-1 text-lg"></i> <span>Sesiones de sparring avanzadas.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-orange-500 mr-3 mt-1 text-lg"></i> <span>Asesoría de fuerza y acondicionamiento.</span>
                                    </li>
                                </ul>
                            </div>

                            {{-- Botón de Acción --}}
                            <a href="/register" 
                                class="mt-auto block w-full py-4 rounded-full font-black text-xl tracking-widest 
                                    {{ $loop->iteration == 2 ? 'bg-orange-500 text-black shadow-lg shadow-orange-500/50 hover:bg-orange-400' : 'bg-gray-700 text-white hover:bg-gray-600' }} 
                                    transition duration-300 transform hover:scale-[0.98]">
                                COMIENZA AHORA
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 text-center p-10 bg-gray-800 rounded-xl text-gray-500 italic">
                        <i class="fas fa-info-circle mr-2"></i> No se encontraron planes activos.
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>

    {{-- ************************************************* --}}
    {{-- 3. SECCIÓN DE CARACTERÍSTICAS (Detalle de Valor) --}}
    {{-- ************************************************* --}}
    <div class="py-20 bg-gray-100 border-b border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-orange-600 font-extrabold tracking-widest uppercase">NUESTRO COMPROMISO</h2>
                <p class="mt-2 text-4xl leading-8 font-black tracking-tight text-gray-900 sm:text-5xl">
                    LA VENTAJA DEL TIGRE
                </p>
            </div>

            <div class="mt-16">
                <dl class="space-y-12 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-12 md:gap-y-12">
                    
                    {{-- Característica 1 --}}
                    <div class="relative group p-6 bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-orange-500">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-full bg-orange-500 text-white shadow-xl group-hover:bg-orange-600 transition">
                                <i class="fas fa-fist-raised h-6 w-6 text-xl"></i>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-extrabold text-gray-900 mt-1">Metodología de Combate</p>
                        </dt>
                        <dd class="mt-3 ml-20 text-lg text-gray-600">
                            Entrenamiento táctico real, no solo fitness. Programas diseñados para desarrollar boxeo de competición.
                        </dd>
                    </div>

                    {{-- Característica 2 --}}
                    <div class="relative group p-6 bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-orange-500">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-full bg-orange-500 text-white shadow-xl group-hover:bg-orange-600 transition">
                                <i class="fas fa-medal h-6 w-6 text-xl"></i>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-extrabold text-gray-900 mt-1">Coaching Certificado</p>
                        </dt>
                        <dd class="mt-3 ml-20 text-lg text-gray-600">
                            Aprende de ex-campeones y entrenadores avalados. Técnica de primer nivel garantizada.
                        </dd>
                    </div>

                    {{-- Característica 3 --}}
                    <div class="relative group p-6 bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-orange-500">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-full bg-orange-500 text-white shadow-xl group-hover:bg-orange-600 transition">
                                <i class="fas fa-bolt h-6 w-6 text-xl"></i>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-extrabold text-gray-900 mt-1">Rendimiento Extremo</p>
                        </dt>
                        <dd class="mt-3 ml-20 text-lg text-gray-600">
                            Sesiones de acondicionamiento de fuerza, cardio y explosividad que maximizan tu potencial físico.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    
    {{-- ************************************************* --}}
    {{-- 4. SECCIÓN: TESTIMONIOS Y CONFIANZA (Minimalista Oscuro) --}}
    {{-- ************************************************* --}}
    <div class="py-20 bg-black border-t border-orange-500/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-16">
                <h2 class="text-base text-orange-400 font-extrabold tracking-widest uppercase">ÉXITO PROBADO</h2>
                <p class="mt-2 text-4xl leading-8 font-black tracking-tight text-white sm:text-5xl">
                    LA VOZ DE LOS GUERREROS
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                {{-- Testimonio 1 --}}
                <div class="bg-gray-900 p-8 rounded-xl shadow-lg border border-gray-800/80 hover:border-orange-500/50 transition duration-300">
                    <i class="fas fa-quote-left text-orange-500 text-3xl mb-4 opacity-50"></i>
                    <blockquote class="text-xl text-gray-300 italic">
                        "El nivel de exigencia es brutal, pero justo lo que necesitaba para romper mis límites. En seis meses, mi resistencia y técnica se dispararon. Máximo respeto."
                    </blockquote>
                    <div class="mt-6 flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover mr-4 ring-2 ring-orange-500" src="https://i.pravatar.cc/150?img=1" alt="Ricardo G.">
                        <div>
                            <p class="text-lg font-bold text-white">RICARDO G.</p>
                            <p class="text-sm text-orange-400 font-medium">Luchador Avanzado</p>
                        </div>
                    </div>
                </div>
                
                {{-- Testimonio 2 --}}
                <div class="bg-gray-900 p-8 rounded-xl shadow-lg border border-gray-800/80 hover:border-orange-500/50 transition duration-300">
                    <i class="fas fa-quote-left text-orange-500 text-3xl mb-4 opacity-50"></i>
                    <blockquote class="text-xl text-gray-300 italic">
                        "El mejor ambiente de entrenamiento. Fui principiante y me trataron como un futuro campeón. La metodología es seria, no es un gimnasio de moda."
                    </blockquote>
                    <div class="mt-6 flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover mr-4 ring-2 ring-orange-500" src="https://i.pravatar.cc/150?img=2" alt="Andrea M.">
                        <div>
                            <p class="text-lg font-bold text-white">ANDREA M.</p>
                            <p class="text-sm text-orange-400 font-medium">Iniciación</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonio 3 --}}
                <div class="bg-gray-900 p-8 rounded-xl shadow-lg border border-gray-800/80 hover:border-orange-500/50 transition duration-300">
                    <i class="fas fa-quote-left text-orange-500 text-3xl mb-4 opacity-50"></i>
                    <blockquote class="text-xl text-gray-300 italic">
                        "Si buscas resultados reales y disciplina, este es el lugar. El coaching te empuja más allá de lo que creías posible. 100% enfocado en el combate y la forma física."
                    </blockquote>
                    <div class="mt-6 flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover mr-4 ring-2 ring-orange-500" src="https://i.pravatar.cc/150?img=3" alt="José P.">
                        <div>
                            <p class="text-lg font-bold text-white">JOSÉ P.</p>
                            <p class="text-sm text-orange-400 font-medium">Preparación Física</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ************************************************* --}}
    {{-- 5. SECCIÓN: UBICACIÓN Y CONTACTO (Estilo Limpio y Funcional) --}}
    {{-- ************************************************* --}}
    <div class="py-20 bg-gray-100 border-t border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <p class="mt-2 text-4xl leading-8 font-black tracking-tight text-gray-900 sm:text-5xl">
                    ENCUENTRA TU DOJO
                </p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-xl shadow-2xl border border-gray-200">
                {{-- Contacto --}}
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt text-orange-600 mr-3 text-2xl"></i> DETALLES DE ACCESO
                    </h3>
                    
                    <ul class="space-y-4 text-gray-700 text-xl">
                        <li class="flex items-center">
                            <i class="fas fa-building text-orange-500 mr-3 w-6 text-center"></i> 
                            <span class="font-bold">Dirección:</span> Jr. Anchash 415, of. 302, Huancayo, Perú.
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt text-orange-500 mr-3 w-6 text-center"></i> 
                            <span class="font-bold">Llámanos:</span> 
                            <a href="tel:+51924710687" class="text-orange-600 hover:text-orange-700 ml-2">924 710 687</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-orange-500 mr-3 w-6 text-center"></i> 
                            <span class="font-bold">Email:</span> 
                            <a href="mailto:eltigre6cn11@gmail.com" class="text-orange-600 hover:text-orange-700 ml-2">eltigre6cn11@gmail.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-orange-500 mr-3 w-6 text-center"></i> 
                            <span class="font-bold">Horario:</span> Siempre abierto (Clases presenciales).
                        </li>
                    </ul>
                    
                    {{-- Enlaces a Redes Sociales --}}
                    <div class="mt-8 flex items-center space-x-6">
                        <span class="text-xl font-bold text-gray-900">Síguenos:</span>
                        <a href="https://instagram.com/clubdeboxeltigre" target="_blank" title="Instagram" class="text-gray-500 hover:text-pink-600 transition transform hover:scale-110">
                            <i class="fab fa-instagram text-3xl"></i>
                        </a>
                        <a href="#" target="_blank" title="Facebook" class="text-gray-500 hover:text-blue-600 transition transform hover:scale-110">
                            <i class="fab fa-facebook text-3xl"></i>
                        </a>
                    </div>

                    {{-- Botón a Google Maps (URL específica de la ubicación) --}}
                    <a href="https://www.google.com/maps/search/?api=1&query=Jr.+Anchash+415,+of.+302,+Huancayo,+Peru" target="_blank" class="mt-8 inline-flex items-center justify-center px-8 py-3 border border-transparent text-xl font-extrabold rounded-lg text-white bg-orange-600 hover:bg-orange-700 transition shadow-lg shadow-orange-600/30">
                        Ver Ubicación <i class="ml-3 fas fa-map-marked-alt"></i>
                    </a>
                </div>

                {{-- Mapa (iFrame) --}}
                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-300">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.108608882512!2d-75.21639148518923!3d-12.067332291475736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9109745d1d643d9f%3A0xc62b8d009b0b4715!2sJr.%20Ancash%20415%2C%20Huancayo%2012000!5e0!3m2!1sen!2spe!4v1675704000000!5m2!1sen!2spe" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-96 md:h-full">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>