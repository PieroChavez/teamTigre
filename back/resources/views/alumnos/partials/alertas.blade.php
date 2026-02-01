{{-- Notificaciones de Sistema - Estilo Dark Premium --}}

<div class="fixed top-5 right-5 z-[9999] w-full max-w-sm space-y-3 animate-slideIn">
    
    {{-- ALERTAS DE ÉXITO --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms
             class="relative overflow-hidden bg-black/40 backdrop-blur-md border border-green-500/30 p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] flex items-start gap-4">
            {{-- Brillo decorativo lateral --}}
            <div class="absolute inset-y-0 left-0 w-1 bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.8)]"></div>
            
            <div class="flex-shrink-0 bg-green-500/20 p-2 rounded-lg text-green-500">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
            
            <div class="flex-grow">
                <h4 class="text-[10px] font-black text-green-500 uppercase tracking-[0.2em] mb-1">Operación Exitosa</h4>
                <p class="text-sm text-gray-200 font-medium leading-tight">{{ session('success') }}</p>
            </div>

            <button @click="show = false" class="text-gray-500 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    @endif

    {{-- ALERTAS DE ERROR --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms
             class="relative overflow-hidden bg-black/40 backdrop-blur-md border border-red-500/30 p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] flex items-start gap-4">
            <div class="absolute inset-y-0 left-0 w-1 bg-red-500 shadow-[0_0_15px_rgba(239,68,68,0.8)]"></div>
            
            <div class="flex-shrink-0 bg-red-500/20 p-2 rounded-lg text-red-500">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            
            <div class="flex-grow">
                <h4 class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] mb-1">Error de Sistema</h4>
                <p class="text-sm text-gray-200 font-medium leading-tight">{{ session('error') }}</p>
            </div>

            <button @click="show = false" class="text-gray-500 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    @endif

    {{-- VALIDACIONES DE FORMULARIO --}}
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms
             class="relative overflow-hidden bg-black/40 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] flex items-start gap-4">
            <div class="absolute inset-y-0 left-0 w-1 bg-orange-500 shadow-[0_0_15px_rgba(249,115,22,0.8)]"></div>
            
            <div class="flex-shrink-0 bg-orange-500/20 p-2 rounded-lg text-orange-500">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            
            <div class="flex-grow">
                <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-1">Atención Requerida</h4>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-[11px] text-gray-300 font-bold flex items-center gap-2 italic">
                            <span class="w-1 h-1 bg-orange-500/50 rounded-full"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <button @click="show = false" class="text-gray-500 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    @endif
</div>

<style>
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slideIn {
        animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>