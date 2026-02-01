{{-- Modal de Registro de Pago - Estilo Dark Premium --}}
<div x-cloak x-show="openPagoModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">

    <div @click.outside.stop="openPagoModal = false"
         class="bg-[#1a1a1a] border border-white/10 rounded-2xl shadow-[0_0_50px_rgba(0,0,0,1)] w-full max-w-lg overflow-hidden transform transition-all">

        {{-- CABECERA DEL MODAL --}}
        <div class="px-6 py-4 border-b border-white/5 bg-gradient-to-r from-black to-transparent flex justify-between items-center">
            <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.3em] flex items-center gap-3">
                <i class="fa-solid fa-cash-register text-lg"></i> Terminal de Cobro
            </h3>
            <button @click="openPagoModal = false" class="text-gray-500 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- CUERPO DEL MODAL (Inyecta el formulario dark que creamos antes) --}}
        <div class="p-8">
            @include('alumnos.partials.form-registrar-pago', [
                'alumno' => $alumno,
                'tiposPago' => $tiposPago,
                'moneda' => 'S/'
            ])
        </div>

        {{-- PIE DEL MODAL --}}
        <div class="px-8 pb-6">
            <button @click="openPagoModal = false"
                    class="w-full bg-[#222] border border-white/5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:bg-[#2a2a2a] hover:text-white transition-all duration-300">
                Cancelar Operación
            </button>
        </div>
    </div>
</div>