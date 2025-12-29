<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión de Alumnos') }}
                </h2>
                <p class="text-sm text-gray-500">Administra la información de los estudiantes y sus inscripciones</p>
            </div>
            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Nuevo Alumno
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERTAS --}}
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-400 rounded-r-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-bold text-green-700">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-3xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Alumno</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">DNI / Código</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Categoría Activa</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    {{-- Nombre y Email --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @php
                                                $profile = $student->studentProfile;
                                                $initials = collect(explode(' ', $student->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('');
                                            @endphp

                                            <div class="h-10 w-10 flex-shrink-0 rounded-full overflow-hidden 
                                                        @if(optional($profile)->photo) border-2 border-indigo-200 @else bg-indigo-100 text-indigo-700 @endif 
                                                        flex items-center justify-center font-bold text-sm">
                                                
                                                @if(optional($profile)->photo)
                                                    <img src="{{ asset('storage/' . $profile->photo) }}" 
                                                         alt="{{ $student->name }}" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    {{ $initials }}
                                                @endif
                                            </div>

                                            <div class="ml-4">
                                                <a href="{{ route('admin.students.show', $student) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                                    {{ $student->name }}
                                                </a>
                                                <div class="text-xs text-gray-400">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- DNI / Código --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 font-medium">{{ optional($student->studentProfile)->dni ?? '—' }}</div>
                                        <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-tighter">COD: {{ optional($student->studentProfile)->code ?? 'S/C' }}</div>
                                    </td>

                                    {{-- Categoría Activa --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $activeEnrollment = optional(optional($student->studentProfile)->enrollments)->firstWhere('status', 'active');
                                            $categoryName = optional($activeEnrollment)->category->name ?? 'Ninguna';
                                        @endphp
                                        <span class="text-sm text-gray-600 font-medium italic">
                                            {{ $categoryName }}
                                        </span>
                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $status = optional($student->studentProfile)->status ?? 'inactivo'; 
                                            $statusStyles = [
                                                'active' => 'bg-green-100 text-green-700',
                                                'inactive' => 'bg-red-100 text-red-700', 
                                                'suspended' => 'bg-amber-100 text-amber-700'
                                            ][strtolower($status)] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-tighter {{ $statusStyles }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">
                                            <a href="{{ route('admin.students.edit', $student) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors font-bold">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.students.deactivate', $student) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de DESACTIVAR a este alumno?');">
                                                @csrf
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors font-bold text-xs uppercase tracking-widest">
                                                    Desactivar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                            <p class="text-gray-400 font-medium">No hay alumnos registrados con el rol 'alumno'.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> {{-- Fin overflow-x-auto --}}

                {{-- PAGINACIÓN AÑADIDA --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $students->links() }}
                </div>
            </div> {{-- Fin bg-white --}}
        </div>
    </div>
</x-app-layout>