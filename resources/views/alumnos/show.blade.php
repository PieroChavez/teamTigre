<x-app-layout>
    {{-- TITULO DE LA PÁGINA --}}
    @section('header', 'Detalle del Alumno: ' . $alumno->user->name)

    <div class="container mx-auto p-4 sm:p-6 space-y-6">

        {{-- 1. ALERTAS DE SESIÓN Y ERRORES --}}
        @include('alumnos.partials.alertas')

        {{-- 2. CONTENEDOR PRINCIPAL Y PESTAÑAS (CORREGIDO A DARK) --}}
        <div x-data="{ activeTab: 'general' }" 
             class="bg-[#141414] shadow-2xl rounded-2xl p-4 sm:p-8 border border-white/5 transition-all">
            
            {{-- NAVEGACIÓN --}}
            <div class="border-b border-white/10 mb-8">
                <nav class="-mb-px flex space-x-10" aria-label="Tabs">
                    <a @click.prevent="activeTab = 'general'" 
                       :class="{
                           'border-orange-600 text-orange-500 font-black': activeTab === 'general',
                           'border-transparent text-gray-500 hover:text-gray-300 hover:border-gray-700': activeTab !== 'general'
                       }"
                       class="whitespace-nowrap py-4 px-2 border-b-2 font-bold text-sm uppercase tracking-widest cursor-pointer transition-all duration-300">
                        <i class="fa-solid fa-user-gear mr-2 text-lg"></i> Datos y Programas
                    </a>

                    <a @click.prevent="activeTab = 'finanzas'" 
                       :class="{
                           'border-orange-600 text-orange-500 font-black': activeTab === 'finanzas',
                           'border-transparent text-gray-500 hover:text-gray-300 hover:border-gray-700': activeTab !== 'finanzas'
                       }"
                       class="whitespace-nowrap py-4 px-2 border-b-2 font-bold text-sm uppercase tracking-widest cursor-pointer transition-all duration-300">
                        <i class="fa-solid fa-file-invoice-dollar mr-2 text-lg"></i> Sección Financiera
                    </a>
                </nav>
            </div>

            {{-- CONTENIDO DE LAS TABS --}}
            <div class="mt-4">
                {{-- TAB GENERAL --}}
                <div x-show="activeTab === 'general'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak>
                    @include('alumnos.partials.tab-general', ['alumno' => $alumno])
                </div>

                {{-- TAB FINANZAS --}}
                <div x-show="activeTab === 'finanzas'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak>
                    @include('alumnos.partials.tab-finanzas', [
                        'alumno' => $alumno,
                        'tiposPago' => $tiposPago,
                        'moneda' => 'S/'
                    ])
                </div>
            </div>

        </div>
    </div>

    {{-- ================================
        🧾 ABRIR RECIBO EN OTRA PESTAÑA
        ================================ --}}
    @if(session('recibo_pago_id'))
        <script>
            window.open(
                "{{ route('pagos.imprimir_recibo', session('recibo_pago_id')) }}",
                "_blank"
            );
        </script>
    @endif
</x-app-layout>