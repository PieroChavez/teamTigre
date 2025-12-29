<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Coach
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        @forelse ($categories as $category)
            <div class="bg-white p-6 rounded shadow">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">
                        {{ $category->name }}
                    </h3>

                    {{-- BOTÓN ASISTENCIA (ACTUALIZADO) --}}
                    <a href="{{ route('coach.attendance.index', $category) }}"
                       class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                       Tomar asistencia
                    </a>
                </div>

                @if ($category->enrollments->count())
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-left">Alumno</th>
                                <th class="p-2 text-left">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->enrollments as $enrollment)
                                <tr class="border-t">
                                    <td class="p-2">
                                        {{ $enrollment->studentProfile->user->name ?? 'Sin nombre' }}
                                    </td>
                                    <td class="p-2">
                                        {{ ucfirst($enrollment->status) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">
                        No hay alumnos inscritos.
                    </p>
                @endif
            </div>
        @empty
            <div class="bg-yellow-100 p-4 rounded">
                No tienes categorías asignadas.
            </div>
        @endforelse

    </div>
</x-app-layout>