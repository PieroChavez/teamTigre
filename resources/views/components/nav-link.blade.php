@props(['active'])

@php
// Definir las clases de estilo dinámicamente
$classes = ($active ?? false)
            ? 'bg-indigo-50 text-indigo-700 font-semibold' // 👈 Estado Activo (Fondo suave, texto de color de marca)
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; // 👈 Estado Inactivo (Gris, cambio de color y fondo suave al pasar el ratón)

// Clases base compartidas por todos los enlaces
$baseClasses = 'flex items-center py-2 px-3 rounded-md transition-colors w-full';
@endphp

<a {{ $attributes->merge(['class' => $baseClasses . ' ' . $classes]) }}>
    {{ $slot }}
</a>