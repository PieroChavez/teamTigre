<x-app-layout>
    {{-- La directiva @section('header') alimenta el TOPBAR de tu app-layout --}}
    @section('header', 'Crear Nuevo Docente')

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white rounded-xl shadow-2xl p-6 lg:p-8 border border-gray-100">
            
            <h2 class="text-2xl font-extrabold text-indigo-700 mb-6 border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-chalkboard-teacher text-3xl"></i> Registro de Docente y Usuario
            </h2>

            {{-- El formulario apunta al método store del DocenteController --}}
            <form method="POST" action="{{ route('docentes.store') }}" class="space-y-6">
                @csrf
                
                {{-- Bloque de Datos del Usuario (Acceso) --}}
                <div class="border border-indigo-200 bg-indigo-50 p-4 rounded-lg">
                    <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield"></i> Datos de Acceso
                    </h3>
                    
                    {{-- Nombre --}}
                    <div>
                        <x-input-label for="name" :value="__('Nombre Completo')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-white" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email (Usuario)')" class="mt-4" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-white" :value="old('email')" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    {{-- Contraseña --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full bg-white" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-white" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                {{-- Bloque de Datos del Docente (Específicos) --}}
                <div class="pt-4 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-id-card"></i> Datos Específicos del Docente
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- DNI --}}
                        <div>
                            <x-input-label for="dni" value="DNI/Identificación" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="telefono" value="Teléfono" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>
                        
                        {{-- Especialidad --}}
                        <div class="md:col-span-2">
                            <x-input-label for="especialidad" value="Especialidad" />
                            <select id="especialidad" name="especialidad" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Seleccione la especialidad</option>
                                <option value="Boxeo" @selected(old('especialidad') == 'Boxeo')>Boxeo</option>
                                <option value="Kickboxing" @selected(old('especialidad') == 'Kickboxing')>Kickboxing</option>
                                <option value="MMA" @selected(old('especialidad') == 'MMA')>MMA</option>
                                <option value="Fitness" @selected(old('especialidad') == 'Fitness')>Fitness</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('especialidad')" />
                        </div>
                        
                        {{-- CAMPO OCULTO AÑADIDO: Estado por defecto 'activo' --}}
                        <input type="hidden" name="estado" value="activo">
                        {{-- Fin del campo oculto --}}

                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('docentes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition ease-in-out duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Docente
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>