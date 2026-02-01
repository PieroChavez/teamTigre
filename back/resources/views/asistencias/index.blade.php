<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-200">
            Asistencias del Alumno
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">

        @if(session('success'))
            <div class="bg-green-600 text-white p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-600 text-white p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full bg-gray-800 text-gray-200 rounded">
            <thead class="bg-gray-900">
                <tr>
                    <th class="p-3">Fecha</th>
                    <th class="p-3">Hora</th>
                    <th class="p-3">Categoría</th>
                    <th class="p-3">Método</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asistencias as $a)
                    <tr class="border-t border-gray-700">
                        <td class="p-3">{{ $a->fecha }}</td>
                        <td class="p-3">{{ $a->hora_ingreso }}</td>
                        <td class="p-3">{{ $a->inscripcion->categoria->nombre }}</td>
                        <td class="p-3 capitalize">{{ $a->metodo }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-400">
                            No hay asistencias registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
