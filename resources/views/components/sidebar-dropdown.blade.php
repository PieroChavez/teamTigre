@props(['label', 'icon' => null, 'isOpen' => false])

<div x-data="{ open: @json($isOpen) }" class="mb-1 relative group">

    {{-- Botón del Dropdown --}}
    <button @click="open = !open"
            class="w-full flex items-center rounded-lg font-semibold transition-all duration-200 p-2.5
                   text-gray-700 hover:bg-gray-100 hover:text-orange-600"
            :class="{
                'bg-orange-100 text-orange-700 border border-orange-300': open,
                'justify-between': sidebarOpen,
                'justify-center': !sidebarOpen,
                'py-3': !sidebarOpen
            }"
            :title="!sidebarOpen ? '{{ $label }}' : ''">

        <span class="flex items-center"
              :class="{'gap-3': sidebarOpen, 'mx-auto': !sidebarOpen}">

            {{-- Ícono principal --}}
            @if(!empty($icon))
                <i class="fa-solid fa-{{ $icon }} w-5 h-5 flex-shrink-0"
                   :class="open ? 'text-orange-600' : 'text-gray-500'">
                </i>
            @endif

            {{-- Texto --}}
            <span x-show="sidebarOpen"
                  class="truncate flex-1 text-left transition-opacity duration-200">
                {{ $label }}
            </span>
        </span>

        {{-- Flecha --}}
        <i x-show="sidebarOpen"
           class="fa-solid fa-chevron-down h-4 w-4 flex-shrink-0 transition-transform duration-200
                  text-gray-400"
           :class="{'transform rotate-180 text-orange-600': open}">
        </i>
    </button>

    {{-- Contenido del Dropdown --}}
    <div x-show="open && sidebarOpen"
         x-collapse
         class="pl-6 mt-1 space-y-1 border-l-2 border-orange-300 ml-4 py-1"
         x-cloak>
        {{ $slot }}
    </div>

    {{-- Tooltip cuando el sidebar está colapsado --}}
    <div x-show="!sidebarOpen" x-cloak
         x-transition
         class="absolute z-20 top-0 left-full ml-3 py-2
                bg-white rounded-md shadow-xl border border-gray-200
                w-48 text-sm space-y-1"
         @mouseenter.debounce.150ms="open = true"
         @mouseleave.debounce.150ms="open = false">

        <p class="px-3 font-bold text-orange-600 border-b border-gray-200 pb-1 mb-1">
            {{ $label }}
        </p>

        <div class="space-y-1 px-1">
            {{ $slot }}
        </div>
    </div>

</div>
