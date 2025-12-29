<x-app-layout>
    <x-slot name="header">Editar Categoría: {{ $category->name }}</x-slot>

    {{-- BLOQUE DE ALERTA DE ÉXITO (Recomendado para vistas de edición) --}}
    @if (session('success'))
        <div class="max-w-md mx-auto mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    {{-- FIN BLOQUE DE ALERTA --}}

    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf 
            @method('PUT') 
            
            {{-- CAMPO: Nombre de la Categoría --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nombre de la Categoría</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $category->name) }}" 
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
                    value="{{ old('level', $category->level) }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('level') border-red-500 @enderror"
                    placeholder="Ej: Inicial, Intermedio, Avanzado"
                >
                @error('level')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CAMPO: Tipo (Type - Grupo de edad) --}}
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Tipo / Grupo de Edad</label>
                <input
                    type="text"
                    name="type" 
                    id="type" 
                    value="{{ old('type', $category->type) }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('type') border-red-500 @enderror"
                    placeholder="Ej: Juveniles, Adultos, Veteranos"
                >
                @error('type')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CAMPO: Activo (Active) --}}
            <div class="mb-6">
                <label for="active" class="block text-gray-700 font-bold mb-2">Estado</label>
                <select 
                    name="active" 
                    id="active" 
                    required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('active') border-red-500 @enderror"
                >
                    {{-- El valor de 'active' es booleano (1 o 0) --}}
                    <option value="1" @selected(old('active', $category->active) == 1)>Activa</option>
                    <option value="0" @selected(old('active', $category->active) == 0)>Inactiva</option>
                </select>
                @error('active')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="flex justify-end space-x-2 border-t pt-4">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancelar
                </a>
                
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
</x-app-layout>