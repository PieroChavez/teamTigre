<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-edit mr-3 text-indigo-600"></i>
                Editar Inscripción #{{ $enrollment->id }}
            </h2>
            <a href="{{ route('admin.enrollments.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- ALERTA DE ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4" role="alert">
                <p class="font-bold">¡Atención! Hay problemas con la actualización:</p>
                <ul class="list-disc list-inside ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TARJETA DE EDICIÓN --}}
        <div class="bg-white p-8 rounded-xl shadow-2xl">
            
            <form method="POST" action="{{ route('admin.enrollments.update', $enrollment) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6"> 

                    {{-- 1. ALUMNO (INACTIVO) --}}
                    <div class="col-span-full md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alumno</label>
                        <div class="relative">
                            <input type="text" 
                                   value="{{ $enrollment->studentProfile->user->name }} (DNI: {{ $enrollment->studentProfile->dni }})" 
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-gray-100 text-gray-600 cursor-not-allowed" 
                                   disabled>
                            <input type="hidden" name="student_profile_id" value="{{ $enrollment->student_profile_id }}">
                        </div>
                    </div>

                    {{-- 2. CATEGORÍA --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="category_id" id="category_id" 
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 transition @error('category_id') border-red-500 @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        @selected(old('category_id', $enrollment->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 3. PLAN / PRECIO (USANDO SOLES PERUANOS) --}}
                    <div>
                        <label for="plan_id" class="block text-sm font-medium text-gray-700 mb-1">Plan / Precio</label>
                        <select name="plan_id" id="plan_id" 
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 transition @error('plan_id') border-red-500 @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" 
                                        @selected(old('plan_id', $enrollment->plan_id) == $plan->id)>
                                    {{ $plan->name }} (S/ {{ number_format($plan->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('plan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- 4. FECHA INICIO --}}
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                        <input type="date" name="start_date" id="start_date"
                               value="{{ old('start_date', \Carbon\Carbon::parse($enrollment->start_date)->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 transition @error('start_date') border-red-500 @enderror" 
                               required>
                        @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 5. FECHA FIN --}}
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin (Opcional)</label>
                        <input type="date" name="end_date" id="end_date"
                               value="{{ old('end_date', $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date)->format('Y-m-d') : '') }}"
                               class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 transition @error('end_date') border-red-500 @enderror">
                        @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 6. ESTADO --}}
                    <div class="col-span-full md:col-span-2 lg:col-span-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="status" id="status" 
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 transition @error('status') border-red-500 @enderror" required>
                            @foreach(['active', 'suspended', 'finished'] as $statusOption)
                                <option value="{{ $statusOption }}" 
                                        @selected(old('status', $enrollment->status) == $statusOption)>
                                    {{ ucfirst($statusOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
                
                {{-- BOTÓN GUARDAR --}}
                <div class="flex justify-end pt-6 border-t mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</x-app-layout>