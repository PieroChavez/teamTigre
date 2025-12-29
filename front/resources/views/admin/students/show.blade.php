<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.students.index') }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Detalle del Alumno') }}
            </h2>
        </div>
        <p class="text-md text-gray-600 ml-8 mt-1">
            <i class="fas fa-user-graduate mr-1 text-indigo-500"></i>
            Expediente de: <span class="font-extrabold text-indigo-700">{{ $student->name }}</span>
        </p>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes de Sesión --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna Izquierda: Foto y Datos Principales --}}
                <div class="lg:col-span-1 space-y-8">

                    {{-- Card de Foto y Botón de Acción --}}
                    <div class="bg-white shadow-xl rounded-xl p-6 text-center">
                        <h3 class="font-bold text-lg text-gray-700 mb-4 border-b pb-3 flex items-center justify-center">
                            <i class="fas fa-id-card-alt mr-2 text-indigo-500"></i> Ficha Personal
                        </h3>
                        
                        {{-- FOTO DEL ALUMNO --}}
                        <div class="relative w-32 h-32 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-3xl overflow-hidden shadow-inner border-4 border-white">
                            @if(optional($student->studentProfile)->photo)
                                <img src="{{ asset('storage/' . $student->studentProfile->photo) }}" alt="Foto del Alumno" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-circle"></i>
                            @endif
                        </div>

                        <div class="text-center">
                            @if(optional($student->studentProfile)->photo)
                                <a href="{{ route('admin.students.edit-photo', $student->id) }}" class="text-indigo-600 font-medium hover:underline text-sm block">
                                    <i class="fas fa-edit mr-1"></i> Cambiar Fotografía
                                </a>
                            @else
                                <a href="{{ route('admin.students.edit-photo', $student->id) }}" class="text-indigo-600 font-medium hover:underline text-sm block">
                                    <i class="fas fa-camera mr-1"></i> Agregar Fotografía
                                </a>
                            @endif
                        </div>

                        <dl class="mt-6 border-t pt-4 space-y-3 text-left text-sm">
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-fingerprint mr-1"></i> DNI/Cód.</dt>
                                <dd class="text-gray-900 font-bold">{{ optional($student->studentProfile)->dni ?? 'N/A' }} / {{ optional($student->studentProfile)->code ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-envelope mr-1"></i> Email</dt>
                                <dd class="text-gray-900">{{ $student->email }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-phone mr-1"></i> Teléfono</dt>
                                <dd class="text-gray-900">{{ optional($student->studentProfile)->phone ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-birthday-cake mr-1"></i> F. Nacimiento</dt>
                                <dd class="text-gray-900">{{ optional($student->studentProfile)->birth_date ? \Carbon\Carbon::parse($student->studentProfile->birth_date)->format('d/m/Y') : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-venus-mars mr-1"></i> Género</dt>
                                <dd class="text-gray-900 capitalize">{{ optional($student->studentProfile)->gender ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500"><i class="fas fa-user-plus mr-1"></i> Fecha Ingreso</dt>
                                <dd class="text-gray-900">{{ optional($student->studentProfile)->joined_at ? \Carbon\Carbon::parse($student->studentProfile->joined_at)->format('d/m/Y') : 'N/A' }}</dd>
                            </div>
                        </dl>
                        
                    </div>

                    {{-- Card de Estado y Contacto de Emergencia --}}
                    <div class="bg-white shadow-xl rounded-xl p-6">
                        <h3 class="font-bold text-lg text-gray-700 mb-4 border-b pb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-yellow-500"></i> Estado y Notas
                        </h3>

                        {{-- Estado del Perfil --}}
                        <div class="mb-4">
                            <p class="font-semibold text-gray-500">Estado Actual:</p>
                            @php
                                $status = optional($student->studentProfile)->status ?? 'inactivo'; 
                                $color = ['activo' => 'green', 'inactivo' => 'red', 'suspendido' => 'yellow'][$status] ?? 'gray';
                                $statusText = match($status) {
                                    'activo' => 'Activo',
                                    'inactivo' => 'Inactivo',
                                    'suspendido' => 'Suspendido',
                                    default => ucfirst($status),
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 uppercase tracking-wider">
                                {{ $statusText }}
                            </span>
                        </div>

                        {{-- Contacto de Emergencia --}}
                        <div class="mt-4 border-t pt-4">
                            <p class="font-semibold text-gray-500"><i class="fas fa-first-aid mr-1"></i> Contacto de Emergencia:</p>
                            <p class="text-gray-900 font-bold text-lg">{{ optional($student->studentProfile)->emergency_contact ?? 'N/A' }}</p>
                        </div>
                        
                        {{-- Notas --}}
                        <div class="mt-4 border-t pt-4">
                            <p class="font-semibold text-gray-500"><i class="fas fa-clipboard-list mr-1"></i> Notas:</p>
                            <p class="text-gray-700 text-sm italic">{{ optional($student->studentProfile)->notes ?? 'No hay notas registradas.' }}</p>
                        </div>
                    </div>

                </div>
                
                {{-- Columna Derecha: Inscripciones y Pagos --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Botón de Acción Principal --}}
                    @if ($student->studentProfile)
                        <div class="text-right">
                            <a href="{{ route('admin.payments.create', $student->studentProfile->id) }}" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                                <i class="fas fa-cash-register mr-2"></i> Registrar Nuevo Pago
                            </a>
                        </div>
                    @endif

                    {{-- Historial de Inscripciones --}}
                    <div class="bg-white shadow-xl rounded-xl p-6">
                        <h3 class="text-xl font-bold text-gray-700 border-b pb-3 mb-4 flex items-center">
                            <i class="fas fa-list-alt mr-2 text-indigo-500"></i> Historial de Inscripciones
                        </h3>

                        @forelse (optional($student->studentProfile)->enrollments ?? [] as $enrollment)
                            <div class="border border-indigo-100 bg-indigo-50/50 p-4 rounded-lg mb-6 shadow-sm">
                                <div class="flex justify-between items-start mb-3 border-b border-indigo-200 pb-2">
                                    <h4 class="font-extrabold text-xl text-indigo-700">{{ $enrollment->category->name ?? 'Clase Eliminada' }}</h4>
                                    <span class="text-sm font-semibold text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                        Plan: {{ $enrollment->plan->name ?? 'N/A' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mb-4">
                                    <i class="fas fa-calendar-alt mr-1"></i> Periodo: 
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($enrollment->start_date)->format('d/m/Y') }}</span> 
                                    a 
                                    <span class="font-medium">{{ $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date)->format('d/m/Y') : 'Activo' }}</span>
                                </p>
                                
                                {{-- Historial de Pagos (Tabla) --}}
                                <div class="mt-4">
                                    <h5 class="font-bold text-gray-600 mb-2 flex items-center">
                                        <i class="fas fa-money-check-alt mr-2"></i> Detalle de Pagos (Total: {{ $enrollment->payments->count() }})
                                    </h5>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr class="bg-gray-50">
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">F. Vencimiento</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">F. Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @forelse ($enrollment->payments as $payment)
                                                    @php
                                                        $p_status = $payment->status;
                                                        $p_color = match($p_status) {
                                                            'paid' => 'text-green-600 bg-green-50',
                                                            'pending' => 'text-yellow-600 bg-yellow-50',
                                                            'expired' => 'text-red-600 bg-red-50',
                                                            default => 'text-gray-600',
                                                        };
                                                        $p_text = match($p_status) {
                                                            'paid' => 'Pagado',
                                                            'pending' => 'Pendiente',
                                                            'expired' => 'Vencido',
                                                            default => ucfirst($p_status),
                                                        };
                                                    @endphp
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            S/ {{ number_format($payment->amount, 2) }}
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <span class="inline-flex px-2 text-xs font-semibold rounded-full {{ $p_color }}">
                                                                {{ $p_text }}
                                                            </span>
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : 'N/A' }}
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                                            @if ($p_status === 'paid')
                                                                {{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y') }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500 italic">No hay pagos registrados para esta inscripción.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-yellow-50 text-yellow-700 p-4 rounded-lg text-sm border-l-4 border-yellow-500 shadow-sm">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Este alumno no tiene inscripciones activas, o no se encontró su perfil.
                            </div>
                        @endforelse
                    </div>

                    {{-- Enlace de Regreso (Repetido para fácil acceso) --}}
                    <div class="pt-4">
                        <a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-block flex items-center">
                            <i class="fas fa-undo-alt mr-2"></i> Volver a la Lista de Alumnos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>