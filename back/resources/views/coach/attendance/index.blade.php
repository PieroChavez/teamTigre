<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Asistencia - {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        
        {{-- ✅ ENLACE AÑADIDO: Historial de Asistencia de esta Categoría --}}
        <a href="{{ route('coach.attendance.history', $category) }}" 
           class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
            📅 Ver Historial de Asistencia de este Grupo
        </a>
        
        {{-- BLOQUE DE ALERTA FLASH --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                <p class="font-bold">¡Éxito!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        {{-- FIN BLOQUE DE ALERTA FLASH --}}

        <form method="POST" action="{{ route('coach.attendance.store', $category) }}">
            @csrf

            <input type="date" name="date"
                     value="{{ $today }}"
                     class="mb-4 border rounded p-2">

            <table class="w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Alumno</th>
                        <th class="p-2">Presente</th>
                        <th class="p-2">Falta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollments as $enrollment)
                        <tr class="border-t">
                            <td class="p-2">
                                {{ $enrollment->studentProfile->user->name }} {{-- Asegúrate de usar la cadena de relación correcta --}}
                            </td>
                            <td class="text-center">
                                <input type="radio"
                                         name="attendance[{{ $enrollment->id }}]"
                                         value="present" required>
                            </td>
                            <td class="text-center">
                                <input type="radio"
                                         name="attendance[{{ $enrollment->id }}]"
                                         value="absent">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-150">
                Guardar asistencia
            </button>
        </form>

    </div>
</x-app-layout>