{{-- Formulario de Registro de Pago - Versión Final Sincronizada --}}

<form
    action="{{ route('alumnos.registrarPago', $alumno->id) }}"
    method="POST"
    class="space-y-6"
>
    @csrf

    {{-- 1. CAMPOS OCULTOS CRÍTICOS --}}
    {{-- Este es el que faltaba y causaba el error de validación --}}
    <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
    
    {{-- Vinculamos la inscripción que viene de la tabla de cuotas --}}
    <input type="hidden" name="inscripcion_id" x-model="inscripcionId">

    {{-- 2. MONTO DEL PAGO --}}
    <div>
        <label for="monto" class="block text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-2">
            Monto a Cobrar
        </label>

        <div class="relative group">
            <div class="absolute -inset-0.5 bg-green-500/20 rounded-xl blur opacity-0 group-focus-within:opacity-100 transition duration-300"></div>
            
            <div class="relative flex items-center bg-black rounded-xl border border-white/10 group-focus-within:border-green-500/50 transition-all">
                <span class="pl-4 text-green-500 font-black text-lg">S/</span>
                <input
                    type="number"
                    name="monto"
                    step="0.01"
                    min="0.01"
                    required
                    x-model="montoPago"
                    class="block w-full bg-transparent border-none text-white text-2xl font-black py-4 px-3 focus:ring-0 placeholder-white/10"
                    placeholder="0.00"
                >
            </div>
        </div>
        @error('monto')
            <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-widest italic">{{ $message }}</p>
        @enderror
    </div>

    {{-- 3. MÉTODO DE PAGO --}}
    <div>
        <label for="tipo_pago_id" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">
            <i class="fa-solid fa-credit-card mr-1 text-orange-500/70"></i> Método de Pago
        </label>

        <select
            name="tipo_pago_id"
            required
            class="block w-full bg-[#141414] border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 font-bold focus:border-orange-500/50 focus:ring-0 appearance-none transition-all cursor-pointer"
        >
            <option value="" class="bg-[#1a1a1a]">Seleccione método...</option>
            @foreach($tiposPago as $tipo)
                <option value="{{ $tipo->id }}" {{ old('tipo_pago_id') == $tipo->id ? 'selected' : '' }} class="bg-[#1a1a1a]">
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('tipo_pago_id')
            <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-widest italic">{{ $message }}</p>
        @enderror
    </div>

    {{-- 4. REFERENCIA (Sincronizado con 'referencia' en el Controller) --}}
    <div>
        <label for="referencia" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">
            <i class="fa-solid fa-tag mr-1 text-orange-500/70"></i> Nota o Referencia
        </label>

        <input
            type="text"
            name="referencia"
            value="{{ old('referencia') }}"
            class="block w-full bg-[#141414] border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-white/5 font-medium focus:border-orange-500/50 focus:ring-0 transition-all"
            placeholder="Ej: Transferencia BCP, Efectivo..."
        >
    </div>

    {{-- BOTÓN DE ACCIÓN --}}
    <div class="pt-6">
        <button
            type="submit"
            class="w-full relative group overflow-hidden px-4 py-4 rounded-xl bg-green-600 transition-all duration-300 hover:bg-green-500 hover:shadow-[0_0_25px_rgba(34,197,94,0.4)]"
        >
            <div class="relative flex items-center justify-center gap-2 text-white font-black uppercase tracking-[0.2em] text-sm">
                <i class="fa-solid fa-circle-dollar-to-slot text-lg group-hover:scale-110 transition-transform"></i>
                Confirmar y Generar Recibo
            </div>
        </button>
        <p class="text-center text-[9px] text-gray-600 mt-4 uppercase tracking-[0.1em] font-bold">
            Al confirmar, se registrará el ingreso en caja automáticamente.
        </p>
    </div>
</form>