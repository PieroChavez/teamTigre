@props(['estado'])

@php
    $clases = match (strtolower($estado)) {
        'pagada' => 'bg-green-100 text-green-800',
        'pendiente' => 'bg-red-100 text-red-800',
        'parcial' => 'bg-yellow-100 text-yellow-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clases }}">
    {{ ucfirst($estado) }}
</span>