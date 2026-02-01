<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Categoría: {{ $categoria->nombre }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST"
                      action="{{ route('categorias.update', $categoria) }}"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- Campo Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre"
                               value="{{ old('nombre', $categoria->nombre) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('nombre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Campo Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        @error('descripcion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Campo Tarifa Mensual --}}
                    <div>
                        <label for="tarifa_mensual" class="block text-sm font-medium text-gray-700">Tarifa Mensual ($)</label>
                        <input type="number" step="0.01" name="tarifa_mensual" id="tarifa_mensual"
                               value="{{ old('tarifa_mensual', $categoria->tarifa_mensual) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('tarifa_mensual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Campo Activa (Checkbox) --}}
                    <div class="flex items-center">
                        <input id="activa" name="activa" type="checkbox" value="1"
                               @checked(old('activa', $categoria->activa))
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="activa" class="ml-2 block text-sm font-medium text-gray-700">
                            Categoría Activa (Puede recibir nuevos alumnos)
                        </label>
                        @error('activa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>


                    {{-- Botones de Acción --}}
                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Actualizar
                        </button>
                        <a href="{{ route('categorias.index') }}" class="py-2 px-4 text-gray-600 hover:text-gray-900 transition duration-150">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>