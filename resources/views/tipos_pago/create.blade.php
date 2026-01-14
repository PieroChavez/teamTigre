<x-app-layout>
    @section('header', 'Crear Nuevo Tipo de Pago')

    <div class="container mx-auto p-6">
        <div class="max-w-xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-gray-200">
            
            <h1 class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
                <i class="fa-solid fa-cash-register text-blue-600"></i> Formulario de Creación
            </h1>

            {{-- El formulario apunta a la ruta tipos_pago.store --}}
            <form action="{{ route('tipos_pago.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Campo Nombre del Tipo de Pago --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 required">
                        <i class="fa-solid fa-tag mr-1"></i> Nombre (Ej: Efectivo, Tarjeta Crédito, etc.)
                    </label>
                    <input type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: Transferencia Bancaria" autofocus>
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones de Acción --}}
                <div class="pt-4 flex justify-between">
                    {{-- Botón Volver --}}
                    <a href="{{ route('tipos_pago.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                    </a>
                    
                    {{-- Botón Guardar --}}
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition font-semibold">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Tipo de Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>