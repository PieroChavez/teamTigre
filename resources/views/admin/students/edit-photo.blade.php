<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualizar Fotografía:') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('admin.students.update-photo', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="photo" class="block text-gray-700 font-semibold mb-2">Seleccionar Foto:</label>
                        <input type="file" name="photo" id="photo" class="border rounded px-3 py-2 w-full" required>
                    </div>

                    @if($student->studentProfile && $student->studentProfile->photo)
                        <div class="mb-4">
                            <p class="text-gray-500 mb-1">Foto actual:</p>
                            <img src="{{ asset('storage/' . $student->studentProfile->photo) }}" alt="Foto Actual" class="w-32 h-32 object-cover rounded-full">
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <a href="{{ route('admin.students.show', $student->id) }}" class="mr-3 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Actualizar Foto</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
