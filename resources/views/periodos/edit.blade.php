<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-200">
            Editar Período
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST"
              action="{{ route('periodos.update', $periodo) }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            <input name="nombre" placeholder="Nombre"
                   value="{{ old('nombre', $periodo->nombre) }}"
                   class="w-full bg-gray-800 text-white rounded">

            <input name="duracion_meses" type="number" placeholder="Duración (Meses)"
                   value="{{ old('duracion_meses', $periodo->duracion_meses) }}"
                   class="w-full bg-gray-800 text-white rounded">

            <input name="duracion_semanas" type="number" placeholder="Duración (Semanas)"
                   value="{{ old('duracion_semanas', $periodo->duracion_semanas) }}"
                   class="w-full bg-gray-800 text-white rounded">

            <input name="precio_base" type="number" step="0.01" placeholder="Precio Base"
                   value="{{ old('precio_base', $periodo->precio_base) }}"
                   class="w-full bg-gray-800 text-white rounded">

            <button class="bg-indigo-600 px-4 py-2 rounded text-white">
                Actualizar
            </button>
        </form>
    </div>
</x-app-layout>