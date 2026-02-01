@props(['href', 'icon' => null, 'open' => true, 'active' => false])

@php
    // --- Clases Base ---
    $baseClasses = 'flex items-center rounded-lg transition-all duration-200 whitespace-nowrap overflow-hidden';

    // --- Estado ACTIVO (tema claro) ---
    $activeClasses = 'bg-orange-100 text-orange-700 font-semibold py-2 px-3 border border-orange-300';

    // --- Estado INACTIVO (tema claro) ---
    $inactiveClasses = 'text-gray-700 hover:bg-gray-100 hover:text-orange-600 py-2 px-3';

    // --- Sidebar colapsado ---
    $closedClasses = 'justify-center w-full py-3 px-3';

    // --- Clases finales ---
    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);

    if (!$open) {
        $classes .= ' ' . $closedClasses;
    }
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => $classes]) }}
   @click="if (window.innerWidth < 1024) sidebarOpen = false"
   :class="{'w-10 h-10': !sidebarOpen}"
   :title="!sidebarOpen ? '{{ $slot }}' : ''">

    {{-- Ícono --}}
    @if(!empty($icon))
        <i class="fa-solid fa-{{ $icon }} w-5 h-5 flex-shrink-0
           {{ $active ? 'text-orange-600' : 'text-gray-500' }}"
           :class="{
               'mr-2': sidebarOpen,
               'mx-auto': !sidebarOpen
           }">
        </i>
    @endif

    {{-- Texto --}}
    <span x-show="sidebarOpen"
          class="flex-1 transition-opacity duration-200">
        {{ $slot }}
    </span>
</a>
