{{-- resources/views/alumnos/partials/datos-card.blade.php --}}

<div class="bg-[#1a1a1a] shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-2xl p-6 border border-white/5 space-y-6 relative overflow-hidden group">
    
    {{-- Efecto decorativo de fondo --}}
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-orange-600/10 rounded-full blur-3xl group-hover:bg-orange-600/20 transition-all duration-700"></div>

    {{-- 1. HEADER Y BOTONES DE ACCIÓN --}}
    <div class="border-b border-white/10 pb-5">
        <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.3em] flex items-center mb-4">
            <i class="fa-solid fa-address-card mr-2 text-lg"></i> Perfil Atleta
        </h3>

        <div class="flex flex-col space-y-3">
            {{-- BOTÓN: IMPRIMIR FICHA --}}
            <a href="{{ route('inscripciones.imprimirFicha', $alumno->id) }}"
               target="_blank"
               class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-[#222] text-white rounded-xl border border-white/10 shadow-lg hover:border-orange-500/50 hover:bg-orange-600/10 transition-all duration-300 font-black text-[10px] uppercase tracking-widest group/btn">
                <i class="fa-solid fa-print mr-2 text-orange-500 group-hover/btn:scale-110 transition-transform"></i> 
                Imprimir Ficha
            </a>

            {{-- BOTÓN: EDICIÓN --}}
            <a href="{{ route('alumnos.edit', $alumno->id) }}"
               class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-orange-600 text-white rounded-xl shadow-[0_5px_15px_rgba(234,88,12,0.3)] hover:bg-orange-500 hover:shadow-orange-500/40 transition-all duration-300 font-black text-[10px] uppercase tracking-widest">
                <i class="fa-solid fa-pencil mr-2"></i> Editar Perfil
            </a>
        </div>
    </div>

    {{-- 2. FOTO Y HORARIO --}}
    <div class="flex flex-col items-center space-y-5 relative">
        {{-- VISTA DE LA FOTO CON EFECTO NEÓN --}}
        <div class="relative">
            <div class="absolute inset-0 bg-orange-600 rounded-full blur-md opacity-20 group-hover:opacity-40 transition-opacity"></div>
            <div class="relative w-32 h-32 rounded-full border-[3px] border-white/10 p-1 bg-[#111] shadow-2xl">
                <img class="w-full h-full rounded-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" 
                     src="{{ $alumno->user->foto_url ?? asset('images/default-avatar.png') }}" 
                     alt="Foto de {{ $alumno->user->name }}">
            </div>
        </div>
        
        <div class="text-center">
            <h4 class="text-xl font-black text-white uppercase tracking-tighter leading-none">{{ $alumno->user->name }}</h4>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mt-2 italic">Miembro Activo</p>
        </div>
        
        {{-- BOTÓN DE VER HORARIO --}}
        <a href="#" {{-- route('alumnos.horario', $alumno->id) --}}
           class="w-full text-center inline-flex items-center justify-center px-4 py-3 bg-[#111] text-gray-300 rounded-xl border border-white/5 hover:border-orange-500/30 hover:text-white transition-all font-black text-[10px] uppercase tracking-widest">
            <i class="fa-solid fa-calendar-alt mr-2 text-orange-500"></i> Mi Horario
        </a>
    </div>
    
    {{-- 3. DETALLES DEL ALUMNO --}}
    <div class="bg-black/30 rounded-2xl p-4 space-y-4 border border-white/5">
        <div class="space-y-3 text-[11px]">
            <p class="flex justify-between items-center">
                <span class="font-black text-gray-600 uppercase tracking-tighter">Documento</span>
                <span class="font-bold text-gray-300">{{ $alumno->dni ?? 'N/A' }}</span>
            </p>
            <p class="flex justify-between items-center">
                <span class="font-black text-gray-600 uppercase tracking-tighter">Teléfono</span>
                <span class="font-bold text-gray-300">{{ $alumno->telefono ?? 'N/A' }}</span>
            </p>
            <div class="space-y-1">
                <span class="font-black text-gray-600 uppercase tracking-tighter block">Email</span>
                <span class="font-bold text-orange-500 truncate block">{{ $alumno->user->email ?? 'N/A' }}</span>
            </div>
            <div class="space-y-1">
                <span class="font-black text-gray-600 uppercase tracking-tighter block">Dirección</span>
                <span class="font-bold text-gray-400 leading-tight">{{ $alumno->direccion ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

</div>