<x-app-layout>
    @php
        $title = '✏️ Editar Horario';
        $action = route('horarios.update', $horario);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8 border border-gray-100">
                
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded-lg shadow-sm" role="alert">
                    <p class="font-bold">Modo Edición Múltiple:</p>
                    <p class="text-sm">Selecciona los días que deseas mantener para este horario. Se actualizarán o eliminarán registros según la selección.</p>
                </div>

                <form method="POST" action="{{ $action }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Categoría --}}
                        <div>
                            <x-input-label for="categoria_id" value="Categoría / Tipo de Clase" />
                            <select name="categoria_id" id="categoria_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($categorias as $c)
                                    <option value="{{ $c->id }}" @selected(old('categoria_id', $horario->categoria_id) == $c->id)>
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('categoria_id')" />
                        </div>

                        {{-- Docente --}}
                        <div>
                            <x-input-label for="docente_id" value="Docente Asignado" />
                            <select name="docente_id" id="docente_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled>-- Seleccione un docente --</option>
                                @foreach($docentes as $d)
                                    <option value="{{ $d->id }}" @selected(old('docente_id', $horario->docente_id) == $d->id)>
                                        {{ $d->user_name ?? $d->dni }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('docente_id')" />
                        </div>

                    </div>

                    {{-- Separador --}}
                    <div class="border-t border-gray-100 pt-6"></div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Días de la Semana (Checkboxes) --}}
                        <div>
                            <x-input-label value="Día(s) de la Semana" />
                            <div class="mt-2 grid grid-cols-3 gap-2 text-sm">
                                @foreach(['lunes','martes','miércoles','jueves','viernes','sábado'] as $dia)
                                    <label for="{{ $dia }}" class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" 
                                            name="dias_semana[]" 
                                            id="{{ $dia }}" 
                                            value="{{ $dia }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            @checked(in_array($dia, old('dias_semana', $diasSeleccionados)))
                                        >
                                        <span>{{ ucfirst($dia) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('dias_semana')" />
                        </div>

                        {{-- Hora Inicio --}}
                        <div>
                            <x-input-label for="hora_inicio" value="Hora de Inicio" />
                            <x-text-input type="time" name="hora_inicio" id="hora_inicio"
                                value="{{ old('hora_inicio', \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i')) }}"
                                class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('hora_inicio')" />
                        </div>

                        {{-- Hora Fin --}}
                        <div>
                            <x-input-label for="hora_fin" value="Hora de Fin" />
                            <x-text-input type="time" name="hora_fin" id="hora_fin"
                                value="{{ old('hora_fin', \Carbon\Carbon::parse($horario->hora_fin)->format('H:i')) }}"
                                class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('hora_fin')" />
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100 mt-6">
                        <a href="{{ route('horarios.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50 transition">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition shadow-md">
                            <i class="fa-solid fa-save mr-2"></i> Actualizar Horario(s)
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
