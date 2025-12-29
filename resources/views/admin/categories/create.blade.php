<x-app-layout>
    <x-slot name="header">Crear Nueva Categoría</x-slot>

    {{-- BLOQUE DE ALERTA DE ÉXITO (Si el controlador redirige con 'success') --}}
    @if (session('success'))
        <div class="max-w-md mx-auto mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    {{-- BLOQUE DE ALERTA DE ERRORES GENERALES DE VALIDACIÓN Y DB --}}
    @if ($errors->any())
        <div class="max-w-md mx-auto mb-6">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">¡Error de Guardado!</strong>
                <span class="block sm:inline">Por favor, revisa los siguientes problemas:</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    {{-- 1. Muestra el error de la DB de forma visible --}}
                    @if ($errors->has('db_error_visible'))
                        <li class="font-bold text-base mt-2">
                            Error de Base de Datos: {{ $errors->first('db_error_visible') }}
                        </li>
                    @endif
                    
                    {{-- 2. Muestra los errores de validación de los campos --}}
                    @foreach ($errors->all() as $error)
                        @if ($error !== $errors->first('db_error_visible'))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    {{-- FIN BLOQUE DE ALERTA DE ERRORES GENERALES --}}
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-xl">
        
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            {{-- CAMPO: Nombre de la Categoría --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nombre de la Categoría</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CAMPO: Nivel (Level) --}}
            <div class="mb-4">
                <label for="level" class="block text-gray-700 font-bold mb-2">Nivel</label>
                <input 
                    type="text" 
                    name="level" 
                    id="level" 
                    value="{{ old('level') }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('level') border-red-500 @enderror"
                    placeholder="Ej: Inicial, Intermedio, Avanzado"
                >
                @error('level')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CAMPO: Tipo (Type - Grupo de edad) --}}
            <div class="mb-6">
                <label for="type" class="block text-gray-700 font-bold mb-2">Tipo / Grupo de Edad</label>
                <input
                    type="text"
                    name="type" 
                    id="type" 
                    value="{{ old('type') }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('type') border-red-500 @enderror"
                    placeholder="Ej: Niños, Juveniles, Adultos, Veteranos"
                >
                @error('type')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-2 border-t pt-4">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150">
                    Cancelar
                </a>
                
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-150">
                    Guardar Categoría
                </button>
            </div>
        </form>
    </div>
</x-app-layout>