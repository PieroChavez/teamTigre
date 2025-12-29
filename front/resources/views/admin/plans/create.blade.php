<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.plans.store') }}">
                    @csrf

                    {{-- Nombre del Plan --}}
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Duración en Días --}}
                    <div class="mb-4">
                        <label for="duration_days" class="block font-medium text-sm text-gray-700">Duración (Días)</label>
                        <input type="number" id="duration_days" name="duration_days" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('duration_days') }}">
                        @error('duration_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Precio --}}
                    <div class="mb-4">
                        <label for="price" class="block font-medium text-sm text-gray-700">Precio (S/)</label>
                        <input type="number" id="price" name="price" step="0.01" min="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('price') }}">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Estado Activo --}}
                    <div class="mb-6 flex items-center">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" id="active" name="active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                        <label for="active" class="ml-2 block text-sm font-medium text-gray-700">Activo (Mostrar este plan)</label>
                        @error('active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest mr-2">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Guardar Plan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>