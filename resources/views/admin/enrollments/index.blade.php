<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <i class="fas fa-user-check mr-2"></i> {{ __('Gestión de Inscripciones') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- MENSAJES DE ALERTA --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif


        {{-- MENSAJES DE ERROR DE VALIDACIÓN --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <p class="font-bold mb-1">Se encontraron los siguientes problemas:</p>
                <ul class="list-disc list-inside ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO DE REGISTRO --}}
        <div class="bg-white p-6 rounded-lg shadow-xl mb-8">
            <h3 class="text-xl font-extrabold text-gray-800 mb-4 border-b pb-2 flex items-center">
                <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> Registrar Nueva Inscripción
            </h3>

            <form method="POST" action="{{ route('admin.enrollments.store') }}">
                @csrf

                {{-- AJUSTE DE GRID: 4 campos + Botón (5 columnas) --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4"> 
                    
                    {{-- 1. ALUMNO --}}
                    <div class="md:col-span-2">
                        <label for="student_profile_id" class="text-sm font-medium block text-gray-700">Alumno</label>
                        <select name="student_profile_id" id="student_profile_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('student_profile_id') border-red-500 @enderror" required>
                            <option value="">Seleccione alumno</option>
                            @foreach($students as $student)
                                @if($student->studentProfile)
                                    <option value="{{ $student->studentProfile->id }}" @selected(old('student_profile_id') == $student->studentProfile->id)>
                                        {{ $student->name }} ({{ $student->studentProfile->dni }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('student_profile_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 2. PLAN --}}
                    <div class="md:col-span-1">
                        <label for="plan_id" class="text-sm font-medium block text-gray-700">Plan</label>
                        <select name="plan_id" id="plan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('plan_id') border-red-500 @enderror" required>
                            <option value="">Seleccione plan</option>
                            @isset($plans)
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                                        {{ $plan->name }} (S/ {{ number_format($plan->price, 2) }})
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('plan_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- 3. CATEGORÍA --}}
                    <div class="md:col-span-1">
                        <label for="category_id" class="text-sm font-medium block text-gray-700">Categoría</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror" required>
                            <option value="">Seleccione categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- FECHA INICIO --}}
                    <div>
                        <label for="start_date" class="text-sm font-medium block text-gray-700">Fecha Inicio</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', now()->format('Y-m-d')) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror" required>
                        @error('start_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- SEGUNDA FILA DE DATOS --}}
                    
                    {{-- FECHA FIN --}}
                    <div class="md:col-span-2">
                        <label for="end_date" class="text-sm font-medium block text-gray-700">Fecha Fin (Opcional)</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @enderror">
                        @error('end_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- ESTADO INICIAL --}}
                    <div class="md:col-span-2">
                        <label for="status" class="text-sm font-medium block text-gray-700">Estado Inicial</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror" required>
                            <option value="active" @selected(old('status', 'active') == 'active')>Activo</option>
                            <option value="pending" @selected(old('status') == 'pending')>Pendiente</option>
                            <option value="suspended" @selected(old('status') == 'suspended')>Suspendido</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- BOTÓN --}}
                    <div class="flex items-end md:col-span-1">
                        <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-bold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-1"></i> Inscribir Alumno
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- LISTADO --}}
        <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Alumno</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Categoría</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Plan Contratado</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Precio (S/)</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Inicio</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Fin</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Estado</th>
                        <th class="p-3 text-center text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($enrollments as $enrollment)
                        @php
                            $rowClass = 'hover:bg-gray-50';
                            $remainingDays = null;
                            
                            // Cálculo de días restantes y clases de fila (manteniendo la lógica de Carbon)
                            if ($enrollment->end_date) {
                                $endDate = \Carbon\Carbon::parse($enrollment->end_date);
                                // Usamos diffInDays para calcular la diferencia, 'false' para obtener el signo.
                                $remainingDays = now()->diffInDays($endDate, false); 

                                if ($remainingDays < 0 && $enrollment->status === 'active') {
                                    $rowClass = 'bg-red-50/70 hover:bg-red-100/90'; 
                                } elseif ($remainingDays >= 0 && $remainingDays <= 7 && $enrollment->status === 'active') {
                                    $rowClass = 'bg-yellow-50/70 hover:bg-yellow-100/90';
                                } elseif ($enrollment->status !== 'active') {
                                    $rowClass = 'bg-gray-100/70 hover:bg-gray-200/90 opacity-80';
                                }
                            }
                        @endphp
                        
                        <tr class="{{ $rowClass }} transition"> 
                            <td class="p-3 text-gray-700 font-medium">
                                {{ $enrollment->studentProfile->user->name ?? 'N/A' }}
                                <span class="block text-xs text-gray-500">{{ $enrollment->studentProfile->dni ?? '' }}</span>
                            </td>
                            <td class="p-3 text-gray-700">
                                {{ $enrollment->category->name ?? 'N/A' }}
                            </td>
                            
                            {{-- MOSTRAR NOMBRE DEL PLAN --}}
                            <td class="p-3 font-medium text-gray-800">
                                {{ $enrollment->plan->name ?? 'SIN PLAN' }}
                            </td>

                            {{-- MOSTRAR PRECIO DEL PLAN --}}
                            <td class="p-3 font-bold text-green-700 whitespace-nowrap">
                                S/ {{ number_format($enrollment->plan->price ?? 0, 2) }}
                            </td>

                            <td class="p-3 text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($enrollment->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="p-3 text-gray-700 whitespace-nowrap">
                                {{ $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date)->format('d/m/Y') : 'INDEFINIDO' }}
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs rounded font-bold whitespace-nowrap
                                    @if($enrollment->status === 'active') bg-green-100 text-green-700
                                    @elseif($enrollment->status === 'suspended') bg-yellow-100 text-yellow-700
                                    @elseif($enrollment->status === 'pending') bg-blue-100 text-blue-700
                                    @else bg-gray-200 text-gray-700
                                    @endif">
                                    {{ strtoupper($enrollment->status) }}
                                </span>
                                {{-- Indicador visual de días restantes --}}
                                @if(isset($remainingDays) && $remainingDays <= 7 && $remainingDays >= 0 && $enrollment->status === 'active')
                                    <p class="text-xs text-yellow-600 mt-1"><i class="fas fa-exclamation-triangle"></i> Vence en {{ $remainingDays }} días</p>
                                @endif
                                @if(isset($remainingDays) && $remainingDays < 0 && $enrollment->status === 'active')
                                    <p class="text-xs text-red-600 mt-1"><i class="fas fa-times-circle"></i> Vencida hace {{ abs($remainingDays) }} días</p>
                                @endif
                            </td>
                            
                            {{-- COLUMNA DE ACCIONES CONDICIONALES --}}
                            <td class="p-3 text-center">
                                <div class="flex justify-center space-x-3 items-center whitespace-nowrap"> 
                                    
                                    {{-- 1. ACCIÓN PRINCIPAL (Condicional) --}}
                                    
                                    @if ($enrollment->status === 'active' && (!isset($remainingDays) || $remainingDays >= 0))
                                        {{-- ACTIVO NO VENCIDO: Suspender --}}
                                        <form method="POST"
                                            action="{{ route('admin.enrollments.suspend', $enrollment) }}" 
                                            onsubmit="return confirm('¿Está seguro de SUSPENDER la inscripción de {{ $enrollment->studentProfile->user->name ?? 'este alumno' }}? Esto detendrá la cuenta de días.')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-yellow-600 hover:text-yellow-800 transition p-1 text-sm font-medium"
                                                    title="Suspender Plan">
                                                Suspender
                                            </button>
                                        </form>

                                    @elseif ($enrollment->status === 'suspended')
                                        {{-- SUSPENDIDO: Reactivar --}}
                                        <form method="POST"
                                            action="{{ route('admin.enrollments.reactivate', $enrollment) }}" 
                                            onsubmit="return confirm('¿Está seguro de REACTIVAR la inscripción de {{ $enrollment->studentProfile->user->name ?? 'este alumno' }}? La cuenta de días se reanudará.')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-blue-600 hover:text-blue-800 transition p-1 text-sm font-medium"
                                                    title="Reactivar Plan">
                                                Reactivar
                                            </button>
                                        </form>
                                        
                                    @elseif (isset($remainingDays) && $remainingDays < 0 && $enrollment->status === 'active')
                                        {{-- VENCIDO Y ACTIVO: Renovar (Generalmente lleva a un formulario de pago) --}}
                                        <a href="{{ route('admin.payments.create', ['enrollment_id' => $enrollment->id]) }}" 
                                            class="text-green-600 hover:text-green-800 transition p-1 text-sm font-medium"
                                            title="Renovar Plan/Registrar Pago">
                                            Renovar/Pagar
                                        </a>
                                    
                                    @elseif (in_array($enrollment->status, ['finished', 'canceled', 'pending']))
                                            {{-- FINALIZADO/CANCELADO/PENDIENTE: Ver Historial --}}
                                        <a href="{{ route('admin.enrollments.show', $enrollment) }}" 
                                            class="text-gray-600 hover:text-gray-800 transition p-1 text-sm font-medium"
                                            title="Ver Detalles">
                                            Ver
                                        </a>

                                    @endif


                                    {{-- 2. ACCIONES SECUNDARIAS (Editar y Finalizar/Eliminar) --}}
                                    
                                    @if (!in_array($enrollment->status, ['finished', 'canceled']))
                                        {{-- Botón EDITAR (Disponible si no está finalizado/cancelado) --}}
                                        <a href="{{ route('admin.enrollments.edit', $enrollment) }}" 
                                            class="text-indigo-600 hover:text-indigo-800 transition p-1 text-sm font-medium"
                                            title="Editar Inscripción">
                                            Editar
                                        </a>
                                        
                                        {{-- Botón FINALIZAR (Siempre disponible si no está finalizado) --}}
                                        <form method="POST"
                                            action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                            onsubmit="return confirm('¿Está seguro de FINALIZAR/CANCELAR la inscripción de {{ $enrollment->studentProfile->user->name ?? 'este alumno' }}? Esto cambiará el estado a \'finished\' o \'canceled\'.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition p-1 text-sm font-medium"
                                                    title="Finalizar Inscripción">
                                                Finalizar
                                            </button>
                                        </form>
                                    @endif
                                    
                                </div>
                            </td>
                            {{-- FIN COLUMNA DE ACCIONES --}}

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-gray-500 bg-gray-50/70 italic">
                                <i class="fas fa-info-circle mr-2"></i> No hay inscripciones registradas. ¡Utiliza el formulario superior para registrar la primera!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            {{ $enrollments->links() }}
        </div>

    </div>
</x-app-layout>