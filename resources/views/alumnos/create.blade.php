<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Nuevo Alumno
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white rounded-xl shadow-2xl p-8 border border-gray-100">
            
            {{-- Título Principal --}}
            <h2 class="text-2xl font-extrabold text-indigo-700 mb-6 border-b border-gray-200 pb-3 flex items-center gap-3">
                <i class="fa-solid fa-user-plus text-3xl text-orange-600"></i>
                Registro de Alumno y Usuario
            </h2>

            {{-- Manejo de Errores con Estilo Elegante (Claro) --}}
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
            
            <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- Bloque de Datos del Usuario (Acceso) --}}
                <div class="border border-indigo-100 bg-indigo-50 p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield"></i> Datos de Acceso (Usuario)
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Nombre --}}
                        <div>
                            <x-input-label for="name" value="Nombre Completo" />
                            {{-- x-text-input por defecto es light mode --}}
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        
                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" value="Email (Usuario)" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="password" value="Contraseña" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>
                
                {{-- Bloque de Datos del Alumno (Específicos) --}}
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-id-card"></i> Datos Específicos del Alumno
                    </h3>
                    
                    {{-- Aquí se incluirán los campos específicos del Alumno (DNI, Teléfono, etc.) --}}
                    @include('alumnos._alumno_fields')
                </div>
                
                {{-- Botones de Acción --}}
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('alumnos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150 shadow-sm">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:ring-4 focus:ring-orange-500/50 transition ease-in-out duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Alumno
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>