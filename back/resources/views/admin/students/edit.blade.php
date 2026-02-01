<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.students.index') }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Editar Alumno') }}
                    </h2>
                </div>
                <p class="text-sm text-gray-500 ml-9">Actualizando el expediente de <span class="font-bold text-indigo-600">{{ $student->name }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl shadow-gray-100 border border-gray-100 sm:rounded-3xl overflow-hidden">
                <form method="POST" action="{{ route('admin.students.update', $student) }}" class="p-8 md:p-10 space-y-10">
                    @csrf
                    @method('PUT')

                    {{-- SECCIÓN 1: DATOS DE USUARIO --}}
                    <div>
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-100">1</div>
                            <h3 class="text-lg font-bold text-gray-800 italic">Cuenta de Usuario</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('Nombre Completo')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="name" name="name" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('name', $student->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Correo Electrónico')" class="font-bold text-gray-700 ml-1" />
                                <x-text-input id="email" name="email" type="email" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('email', $student->email)" required />
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN CONTRASEÑA (ESTILO DIFERENCIADO) --}}
                    <div class="bg-gray-50/50 rounded-3xl p-6 border border-gray-100 border-dashed">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <h4 class="text-sm font-bold text-gray-800 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Seguridad (Opcional)
                            </h4>
                            <p class="text-xs text-gray-400 italic">Deja los campos vacíos si no deseas cambiar la contraseña actual.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-text-input id="password" name="password" type="password" class="block w-full border-gray-200 bg-white rounded-2xl focus:ring-indigo-500 py-3 shadow-sm" placeholder="Nueva contraseña" />
                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                            <div class="space-y-2">
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full border-gray-200 bg-white rounded-2xl focus:ring-indigo-500 py-3 shadow-sm" placeholder="Confirmar nueva contraseña" />
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- SECCIÓN 2: PERFIL --}}
                    <div>
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-100">2</div>
                            <h3 class="text-lg font-bold text-gray-800 italic">Expediente Personal</h3>
                        </div>

                        @php $profile = $student->studentProfile; @endphp

                        @if ($profile)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div class="space-y-2">
                                    <x-input-label for="dni" :value="__('DNI / Identificación')" class="font-bold text-gray-700 ml-1" />
                                    <x-text-input id="dni" name="dni" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('dni', $profile->dni)" required />
                                    <x-input-error :messages="$errors->get('dni')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="code" :value="__('Código Interno')" class="font-bold text-gray-700 ml-1" />
                                    <x-text-input id="code" name="code" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('code', $profile->code)" />
                                    <x-input-error :messages="$errors->get('code')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="phone" :value="__('Teléfono Móvil')" class="font-bold text-gray-700 ml-1" />
                                    <x-text-input id="phone" name="phone" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('phone', $profile->phone)" />
                                    <x-input-error :messages="$errors->get('phone')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="birth_date" :value="__('Fecha de Nacimiento')" class="font-bold text-gray-700 ml-1" />
                                    <x-text-input id="birth_date" name="birth_date" type="date" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('birth_date', $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('Y-m-d') : '')" />
                                    <x-input-error :messages="$errors->get('birth_date')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="gender" :value="__('Género')" class="font-bold text-gray-700 ml-1" />
                                    <select id="gender" name="gender" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3 px-4 shadow-sm text-sm font-medium">
                                        <option value="">Seleccione</option>
                                        @foreach (['masculino', 'femenino', 'otro'] as $g)
                                            <option value="{{ $g }}" @selected(old('gender', $profile->gender) == $g)>{{ ucfirst($g) }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="status" :value="__('Estado General')" class="font-bold text-gray-700 ml-1" />
                                    <select id="status" name="status" class="block w-full border-gray-200 bg-indigo-50/50 text-indigo-700 font-bold rounded-2xl focus:ring-indigo-500 py-3 px-4 shadow-sm text-sm">
                                        @foreach (['activo', 'inactivo', 'suspendido'] as $s)
                                            <option value="{{ $s }}" @selected(old('status', $profile->status) == $s)>{{ strtoupper($s) }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" />
                                </div>

                                <div class="md:col-span-3 space-y-2">
                                    <x-input-label for="emergency_contact" :value="__('Contacto de Emergencia (Nombre y Parentesco)')" class="font-bold text-gray-700 ml-1" />
                                    <x-text-input id="emergency_contact" name="emergency_contact" type="text" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 py-3" :value="old('emergency_contact', $profile->emergency_contact)" placeholder="Ej. Ana Pérez (Madre) - 999 888 777" />
                                    <x-input-error :messages="$errors->get('emergency_contact')" />
                                </div>

                                <div class="md:col-span-3 space-y-2">
                                    <x-input-label for="notes" :value="__('Notas del Administrador / Historial')" class="font-bold text-gray-700 ml-1" />
                                    <textarea id="notes" name="notes" rows="4" class="block w-full border-gray-200 bg-gray-50/30 rounded-2xl focus:ring-indigo-500 shadow-sm py-3 px-4">{{ old('notes', $profile->notes) }}</textarea>
                                    <x-input-error :messages="$errors->get('notes')" />
                                </div>
                            </div>
                        @else
                            <div class="p-6 bg-red-50 border border-red-100 rounded-3xl flex items-center gap-4">
                                <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                <p class="text-red-700 font-bold text-sm">Error: El perfil de estudiante no ha sido creado. No se pueden editar los datos detallados.</p>
                            </div>
                        @endif
                    </div>

                    {{-- ACCIONES FINALES --}}
                    <div class="flex items-center justify-between pt-8 border-t border-gray-100">
                        <a href="{{ route('admin.students.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                            Cancelar cambios
                        </a>
                        <button type="submit" class="inline-flex justify-center items-center px-10 py-4 bg-indigo-600 border border-transparent rounded-2xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            {{ __('Actualizar Alumno') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>