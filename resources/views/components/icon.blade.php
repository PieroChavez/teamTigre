@props(['name', 'class' => 'w-5 h-5'])

@php
// El componente se encarga de inyectar el SVG.
// Puedes usar un paquete como blade-ui-kit/blade-heroicons
// O si no tienes el paquete, debes pegar el SVG directamente aquí
// (Esto es tedioso, así que usaremos la convención de un paquete popular).
// Si quieres seguir con el método manual, usa el método simple de Font Awesome.
@endphp

{{-- Si ya tienes un paquete de Blade Icons (como blade-heroicons) instalado: --}}
{{-- <x-heroicon-s-{{ $name }} {{ $attributes->merge(['class' => $class]) }} /> --}}

{{-- Si prefieres seguir con una solución simple por CDN (como Font Awesome): --}}
<i class="fa-fw fa-solid fa-{{ $name }} {{ $class }}"></i>