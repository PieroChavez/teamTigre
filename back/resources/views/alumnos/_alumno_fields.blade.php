@php
    // Si la variable $alumno no está definida (caso CREATE), 
    // crea un objeto vacío para prevenir errores en los campos.
    if (!isset($alumno)) {
        $alumno = (object)[
            'codigo_barra' => null, 
            'fecha_ingreso' => null,
            'estado' => 'activo'
        ];
    }
    
    // Preparar el valor de fecha de ingreso para el input type="date" (YYYY-MM-DD)
    $fechaIngreso = old('fecha_ingreso', $alumno->fecha_ingreso ?? '');
    if ($fechaIngreso instanceof \Carbon\Carbon) {
        $fechaIngreso = $fechaIngreso->format('Y-m-d');
    }
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Campo: Código de barra --}}
        <div>
            {{-- APLICAMOS LA CLASE PARA HACER EL LABEL MÁS OSCURO --}}
            <x-input-label for="codigo_barra" value="Código de Barra" class="text-gray-900 font-bold" />
            <x-text-input id="codigo_barra" name="codigo_barra" type="text" class="mt-1 block w-full" 
                :value="old('codigo_barra', $alumno->codigo_barra ?? '')" 
                required />
            <x-input-error class="mt-2" :messages="$errors->get('codigo_barra')" />
        </div>

        {{-- Campo: Fecha de ingreso --}}
        <div>
            {{-- APLICAMOS LA CLASE PARA HACER EL LABEL MÁS OSCURO --}}
            <x-input-label for="fecha_ingreso" value="Fecha de Ingreso" class="text-gray-900 font-bold" />
            <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" 
                :value="$fechaIngreso" 
                required />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_ingreso')" />
        </div>

        {{-- Campo: Estado --}}
        <div>
            {{-- APLICAMOS LA CLASE PARA HACER EL LABEL MÁS OSCURO --}}
            <x-input-label for="estado" value="Estado del Alumno" class="text-gray-900 font-bold" />
            
            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                @php
                    $currentStatus = old('estado', $alumno->estado ?? 'activo');
                @endphp
                <option value="activo" @selected($currentStatus === 'activo')>Activo</option>
                <option value="inactivo" @selected($currentStatus === 'inactivo')>Inactivo</option>
                <option value="suspendido" @selected($currentStatus === 'suspendido')>Suspendido</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
        </div>
    </div>
</div>