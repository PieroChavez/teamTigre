<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Registrar Nuevo Alumno') }}
                </h2>
                <p class="text-sm text-gray-500">Crea una cuenta de acceso y expediente personal para el estudiante</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center text-sm font-bold text-indigo-500 hover:text-indigo-700 transition-colors bg-indigo-50 px-4 py-2 rounded-xl">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERTAS Y ERRORES --}}
            @if (session('success'))
                <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-400 rounded-r-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-bold text-green-700">{{ session('success') }}</span>
                </div>
            @endif

            @error('critical_error')
                <div class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-400 rounded-r-xl shadow-sm">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-bold text-red-700">{{ $message }}</span>
                </div>
            @enderror

            <div class="bg-white shadow-xl shadow-gray-100 border border-gray-100 sm:rounded-3xl p-8 md:p-10">
                <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-10">
                    @csrf
                    
                    {{-- SECCIÓN 1: ACCESO --}}
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-100">1</div>
                                <h3 class="text-lg font-bold text-gray-800">Datos de Acceso</h3>
                            </div>
                            {{-- AVISO DE CONTRASEÑA --}}
                            <div class="hidden md:flex items-center px-3 py-1 bg-amber-50 border border-amber-100 rounded-lg">
                                <svg class="w-4 h-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-xs font-medium text-amber-700">Contraseña predeterminada: <strong class="font-bold">12345678</strong></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('Nombre Completo')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="name" name="name" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('name')" required placeholder="Ej. Carlos Ruiz" />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Correo Electrónico')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="email" name="email" type="email" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('email')" required placeholder="alumno@correo.com" />
                                <x-input-error :messages="$errors->get('email')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="password" :value="__('Contraseña')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="password" name="password" type="password" value="12345678" class="block w-full border-gray-200 bg-gray-50/50 rounded-2xl focus:ring-indigo-500 py-3 text-gray-500" required />
                                <x-input-error :messages="$errors->get('password')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" value="12345678" class="block w-full border-gray-200 bg-gray-50/50 rounded-2xl focus:ring-indigo-500 py-3 text-gray-500" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- SECCIÓN 2: PERFIL --}}
                    <div>
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-100">2</div>
                            <h3 class="text-lg font-bold text-gray-800">Información del Alumno</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <x-input-label for="code" :value="__('Código (Opcional)')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="code" name="code" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('code')" placeholder="Ej. AL-2024" />
                                <x-input-error :messages="$errors->get('code')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="dni" :value="__('DNI')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="dni" name="dni" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('dni')" placeholder="N° de documento" />
                                <x-input-error :messages="$errors->get('dni')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="phone" :value="__('Teléfono')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="phone" name="phone" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('phone')" placeholder="987654321" />
                                <x-input-error :messages="$errors->get('phone')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="birth_date" :value="__('F. Nacimiento')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('birth_date')" />
                                <x-input-error :messages="$errors->get('birth_date')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="gender" :value="__('Género')" class="font-bold text-gray-700 ml-1" />
                                <select name="gender" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3 px-4 shadow-sm text-sm font-medium">
                                    <option value="">Seleccionar</option>
                                    @foreach (['masculino', 'femenino', 'otro'] as $g)
                                        <option value="{{ $g }}" @selected(old('gender') == $g)>{{ ucfirst($g) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('gender')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="emergency_contact" :value="__('Contacto Emergencia')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="emergency_contact" name="emergency_contact" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('emergency_contact')" placeholder="Nombre o Teléfono" />
                                <x-input-error :messages="$errors->get('emergency_contact')" />
                            </div>
                        </div>

                        <div class="mt-8 space-y-2">
                            <x-input-label for="notes" :value="__('Notas y Observaciones')" class="font-bold text-gray-700 ml-1" />
                            <textarea id="notes" name="notes" rows="3" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 shadow-sm placeholder:text-gray-300 py-3 px-4" placeholder="Alguna observación importante del alumno...">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" />
                        </div>
                    </div>

                    {{-- STATUS OCULTO --}}
                    <input type="hidden" name="status" value="activo">

                    {{-- BOTONES --}}
                    <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-gray-100 gap-4">
                        <p class="text-xs text-gray-400 italic">El estado inicial del alumno será 'Activo' por defecto.</p>
                        <div class="flex items-center space-x-4 w-full md:w-auto">
                            <a href="{{ route('admin.students.index') }}" class="flex-1 md:flex-none text-center text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="flex-1 md:flex-none inline-flex justify-center items-center px-8 py-4 bg-indigo-600 border border-transparent rounded-2xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                {{ __('Guardar Alumno') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>