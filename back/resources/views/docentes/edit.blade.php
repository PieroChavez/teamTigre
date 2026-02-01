<x-app-layout>
    {{-- El slot 'header' se define aquí, fuera de @section --}}
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight border-b-2 border-indigo-200 pb-2 flex items-center gap-3">
            <i class="fa-solid fa-pen-to-square text-indigo-600"></i> Editar Docente: {{ $docente->user->name ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        
        {{-- ========================================================= --}}
        {{-- !!! BLOQUE DE ALERTAS DE SESIÓN (SUCCESS/ERROR) !!! --}}
        {{-- Muestra la alerta si el controlador redirige con 'success' o 'error' --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold">¡Operación Exitosa!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold">Error en el Proceso</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        {{-- ========================================================= --}}


        <div class="bg-white rounded-xl shadow-2xl p-6 lg:p-8 border border-gray-100">
            
            <h2 class="text-2xl font-extrabold text-indigo-700 mb-6 border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-chalkboard-teacher text-3xl"></i> Modificar Datos del Docente
            </h2>

            <form method="POST" action="{{ route('docentes.update', $docente->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                {{-- Bloque de Datos del Usuario (Acceso) --}}
                <div class="border border-indigo-200 bg-indigo-50 p-6 rounded-xl shadow-inner">
                    <h3 class="text-xl font-bold text-indigo-800 mb-4 flex items-center gap-2 border-b border-indigo-300 pb-2">
                        <i class="fa-solid fa-user-shield text-indigo-600"></i> Datos de Acceso
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre Completo')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-white" :value="old('name', $docente->user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email (Usuario)')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-white" :value="old('email', $docente->user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mt-5 italic pt-3 border-t border-indigo-200">
                        Deje los campos de contraseña vacíos si no desea cambiarlas.
                    </p>
                    
                    {{-- Contraseña (Opcional) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="password" :value="__('Nueva Contraseña')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full bg-white" autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-white" autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                {{-- Bloque de Datos del Docente --}}
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                        <i class="fa-solid fa-id-card text-indigo-600"></i> Datos Específicos del Docente
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- DNI --}}
                        <div>
                            <x-input-label for="dni" value="DNI/Identificación" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $docente->dni)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="telefono" value="Teléfono" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $docente->telefono)" />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        {{-- Especialidad --}}
                        <div>
                            <x-input-label for="especialidad" value="Especialidad" />
                            <select id="especialidad" name="especialidad" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" required>
                                @foreach(['Boxeo', 'Kickboxing', 'MMA', 'Fitness'] as $esp)
                                    <option value="{{ $esp }}" @selected(old('especialidad', $docente->especialidad) == $esp)>{{ $esp }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('especialidad')" />
                        </div>
                        
                        {{-- ESTADO (Ocupa una columna propia) --}}
                        <div>
                            <x-input-label for="estado" value="Estado del Docente" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" required>
                                <option value="activo" @selected(old('estado', $docente->estado) == 'activo')>Activo</option>
                                <option value="inactivo" @selected(old('estado', $docente->estado) == 'inactivo')>Inactivo</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                        </div>

                        {{-- EXPERIENCIA / PERFIL (Ocupa el resto del ancho) --}}
                        <div class="md:col-span-2"> 
                            <x-input-label for="experiencia" value="Experiencia / Perfil Profesional" />
                            <p class="mt-1 text-xs text-gray-500">
                                Detalle las certificaciones, especializaciones y años de experiencia en la enseñanza de deportes de contacto.
                            </p>
                            <textarea 
                                id="experiencia" 
                                name="experiencia" 
                                rows="5" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                            >{{ old('experiencia', $docente->experiencia ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('experiencia')" />
                        </div>
                        {{-- FIN EXPERIENCIA --}}

                    </div>
                </div>

                {{-- Botones de Acción (MODIFICADOS para volver a SHOW) --}}
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    
                    {{-- CANCELAR: Vuelve a la vista de detalle del docente --}}
                    <a href="{{ route('docentes.show', $docente->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150 shadow-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar y Volver
                    </a>
                    
                    {{-- GUARDAR --}}
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition ease-in-out duration-150 shadow-lg">
                        <i class="fa-solid fa-save mr-2"></i> Actualizar Docente
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>