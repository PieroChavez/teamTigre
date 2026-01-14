{{-- Formulario de Asignación de Cuota - Estilo Dark Premium --}}

<form method="POST" action="{{ route('alumnos.asignarCuotaPendiente', $alumno) }}" class="space-y-6">
    @csrf

    {{-- 1. SELECCIÓN DE INSCRIPCIÓN --}}
    <div>
        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-2">
            <i class="fa-solid fa-file-signature mr-1"></i> Vincular a Inscripción
        </label>
        <div class="relative">
            <select name="inscripcion_id" required 
                class="w-full bg-[#141414] border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 font-bold focus:border-orange-500/50 focus:ring-0 appearance-none cursor-pointer transition-all">
                <option value="" class="bg-[#1a1a1a]">Seleccione inscripción...</option>
                @foreach($alumno->inscripciones as $inscripcion)
                    <option value="{{ $inscripcion->id }}" class="bg-[#1a1a1a]">
                        {{ $inscripcion->categoria->nombre }} (ID: #{{ $inscripcion->id }})
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-orange-500">
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    {{-- 2. SELECCIÓN DE CONCEPTO --}}
    <div>
        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">
            <i class="fa-solid fa-list-check mr-1 text-orange-500/70"></i> Concepto de Cobro
        </label>
        <div class="relative">
            <select name="concepto_pago_id" required 
                class="w-full bg-[#141414] border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 font-bold focus:border-orange-500/50 focus:ring-0 appearance-none cursor-pointer transition-all">
                @foreach($conceptosPago as $concepto)
                    <option value="{{ $concepto->id }}" class="bg-[#1a1a1a]">
                        {{ $concepto->nombre }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-orange-500">
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    {{-- 3. DESCUENTO APLICADO --}}
    <div>
        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">
            <i class="fa-solid fa-scissors mr-1 text-orange-500/70"></i> Descuento Especial (S/)
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">
                S/
            </div>
            <input type="number" step="0.01" name="descuento" value="0"
                class="w-full bg-[#141414] border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white font-black text-lg focus:border-orange-500/50 focus:ring-0 transition-all placeholder-white/5"
                placeholder="0.00">
        </div>
        <p class="text-[9px] text-gray-600 mt-2 uppercase tracking-widest font-bold italic">
            * El descuento se restará del monto base del concepto.
        </p>
    </div>

    {{-- BOTÓN DE ACCIÓN --}}
    <div class="pt-4">
        <button type="submit" 
            class="w-full group relative flex items-center justify-center gap-3 bg-orange-600 hover:bg-orange-500 text-white py-4 rounded-xl font-black uppercase tracking-[0.2em] text-sm shadow-[0_0_20px_rgba(234,88,12,0.2)] hover:shadow-[0_0_30px_rgba(234,88,12,0.4)] transition-all duration-300 overflow-hidden">
            <span class="relative z-10 flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-dollar text-lg group-hover:rotate-12 transition-transform"></i>
                Asignar Nueva Cuota
            </span>
            {{-- Efecto de brillo al pasar el ratón --}}
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
        </button>
    </div>
</form>