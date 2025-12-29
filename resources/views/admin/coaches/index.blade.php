<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión de Coaches') }}
                </h2>
                <p class="text-sm text-gray-500">Administra el equipo de entrenadores y sus estados</p>
            </div>
            <a href="{{ route('admin.coaches.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Nuevo Coach
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Entrenador</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">F. Nacimiento</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($coaches as $coach)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                                                {{ substr($coach->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $coach->name }}</div>
                                                <div class="text-xs text-gray-400">DNI: {{ $coach->coachProfile->dni ?? 'No reg.' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $coach->email }}</div>
                                        <div class="text-xs font-semibold text-indigo-500">{{ $coach->coachProfile->phone ?? 'Sin teléfono' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $coach->coachProfile?->birth_date 
                                            ? \Carbon\Carbon::parse($coach->coachProfile->birth_date)->format('d/m/Y') 
                                            : '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $status = $coach->coachProfile->status ?? 'inactivo';
                                            $statusStyles = [
                                                'activo' => 'bg-green-100 text-green-700',
                                                'ausente' => 'bg-amber-100 text-amber-700',
                                                'inactivo' => 'bg-red-100 text-red-700',
                                            ][$status] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-tighter {{ $statusStyles }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">
                                            <a href="{{ route('admin.coaches.edit', $coach) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors font-bold">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.coaches.destroy', $coach) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Estás seguro de desactivar a este entrenador? Su estado cambiará a Inactivo.')"
                                                        class="text-red-400 hover:text-red-600 transition-colors font-bold text-xs uppercase tracking-widest">
                                                    Desactivar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <p class="text-gray-400 font-medium">No hay entrenadores registrados actualmente.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>