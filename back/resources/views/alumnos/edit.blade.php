<x-app-layout>
    
    {{-- USAMOS X-SLOT para el encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Editar Alumno: {{ $alumno->user->name ?? 'ID ' . $alumno->id }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white rounded-xl shadow-2xl p-8 border border-gray-100">
            
            <h2 class="text-2xl font-extrabold text-indigo-700 mb-6 border-b border-gray-200 pb-3 flex items-center gap-3">
                <i class="fa-solid fa-user-pen text-3xl text-orange-600"></i>
                Edición de Alumno y Usuario
            </h2>
            
            {{-- ADVERTENCIA: Usuario Eliminado --}}
            @if(!$alumno->user)
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                        <span class="font-bold">¡Advertencia!</span>
                    </div>
                    <p class="mt-1 text-sm">El usuario asociado a este registro de alumno parece haber sido eliminado. La edición de nombre/email/contraseña estará deshabilitada y limitada a los datos específicos del alumno.</p>
                </div>
            @endif

            {{-- Manejo de Errores con Estilo Elegante --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-3 text-xl"></i>
                        <span class="font-bold">Error de Validación:</span>
                    </div>
                    <ul class="list-disc list-inside mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Bloque de Datos del Usuario (Acceso) --}}
                <div class="border border-indigo-100 bg-indigo-50 p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield"></i> Datos de Acceso (Usuario)
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Nombre del Usuario --}}
                        <div>
                            <x-input-label for="name" value="Nombre Completo (Usuario)" class="text-gray-900 font-bold"/>
                            <x-text-input type="text" name="name" id="name" 
                                :value="old('name', $alumno->user->name ?? '')" 
                                :disabled="!$alumno->user" 
                                class="mt-1 block w-full {{ !$alumno->user ? 'disabled:bg-gray-100' : '' }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Email del Usuario --}}
                        <div>
                            <x-input-label for="email" value="Email (Usuario)" class="text-gray-900 font-bold"/>
                            <x-text-input type="email" name="email" id="email" 
                                :value="old('email', $alumno->user->email ?? '')" 
                                :disabled="!$alumno->user" 
                                class="mt-1 block w-full {{ !$alumno->user ? 'disabled:bg-gray-100' : '' }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>
                    
                    <hr class="border-indigo-200 mt-6 mb-4">

                    {{-- Contraseña (Opcional) --}}
                    <div class="md:w-1/2">
                        <x-input-label for="password" value="Nueva Contraseña (Opcional)" class="text-gray-900 font-bold"/>
                        <x-text-input type="password" name="password" id="password"
                                placeholder="Dejar vacío para no cambiar"
                                :disabled="!$alumno->user"
                                class="mt-1 block w-full {{ !$alumno->user ? 'disabled:bg-gray-100' : '' }}" />
                        <p class="text-gray-600 text-sm mt-1">Solo ingresa un valor si deseas cambiar la contraseña del usuario.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>
                </div>

                {{-- Bloque de Datos del Alumno (Específicos) --}}
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-id-card"></i> Datos Específicos del Alumno
                    </h3>
                    
                    {{-- INCLUIMOS EL FORMULARIO PARCIAL DE ALUMNO --}}
                    @include('alumnos._alumno_fields') 
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('alumnos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150 shadow-sm">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:ring-4 focus:ring-orange-500/50 transition ease-in-out duration-150 shadow-md">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Alumno
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>