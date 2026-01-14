<div class="p-4 bg-white shadow rounded max-w-md mx-auto">
    <h2 class="text-xl font-bold mb-4">Registrar Asistencia por DNI</h2>

    @if($mensaje)
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
            {{ $mensaje }}
        </div>
    @endif

    <form wire:submit.prevent="registrar">
        <input 
            type="text" 
            wire:model="dni" 
            placeholder="Ingrese DNI del alumno"
            class="border rounded p-2 w-full mb-2"
        />
        @error('dni') <span class="text-red-500">{{ $message }}</span> @enderror

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Registrar
        </button>
    </form>
</div>
