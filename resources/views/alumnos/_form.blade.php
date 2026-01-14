{{-- Este archivo contendrá el formulario que se incluirá en create.blade.php y edit.blade.php --}}

@csrf

<div class="space-y-6">
    
    {{-- Selector de Usuario --}}
    <div>
        <label for="user_id" class="block text-sm font-medium text-gray-300 mb-1">Usuario Asociado</label>
        <select name="user_id" id="user_id" 
                class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:ring-orange-500 focus:border-orange-500 @error('user_id') border-red-500 @enderror" 
                required>
            <option value="">-- Seleccione un usuario --</option>
            {{-- La variable $users viene desde el Controller --}}
            @foreach ($users as $user)
                <option value="{{ $user->id }}" 
                    @if(isset($alumno))
                        {{-- En edición, si el user_id coincide, o si es el usuario actualmente asociado al alumno --}}
                        @selected(old('user_id', $alumno->user_id ?? '') == $user->id)
                    @else
                        {{-- En creación, solo usar old() --}}
                        @selected(old('user_id') == $user->id)
                    @endif
                >
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Código de Barra --}}
    <div>
        <label for="codigo_barra" class="block text-sm font-medium text-gray-300 mb-1">Código de Barra</label>
        <input type="text" name="codigo_barra" id="codigo_barra" 
               value="{{ old('codigo_barra', $alumno->codigo_barra ?? '') }}"
               class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:ring-orange-500 focus:border-orange-500 @error('codigo_barra') border-red-500 @enderror"
               placeholder="Ej: ABC12345" required>
        @error('codigo_barra')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    {{-- Fecha de Ingreso y Estado (Grid 2 columnas) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        {{-- Fecha de Ingreso --}}
        <div>
            <label for="fecha_ingreso" class="block text-sm font-medium text-gray-300 mb-1">Fecha de Ingreso</label>
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" 
                   value="{{ old('fecha_ingreso', $alumno->fecha_ingreso?->format('Y-m-d') ?? date('Y-m-d')) }}"
                   class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:ring-orange-500 focus:border-orange-500 @error('fecha_ingreso') border-red-500 @enderror">
            @error('fecha_ingreso')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Estado --}}
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado</label>
            <select name="estado" id="estado" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:ring-orange-500 focus:border-orange-500 @error('estado') border-red-500 @enderror" 
                    required>
                @php
                    $currentStatus = old('estado', $alumno->estado ?? 'activo');
                @endphp
                <option value="activo" @selected($currentStatus == 'activo')>Activo</option>
                <option value="inactivo" @selected($currentStatus == 'inactivo')>Inactivo</option>
                <option value="suspendido" @selected($currentStatus == 'suspendido')>Suspendido</option>
            </select>
            @error('estado')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>