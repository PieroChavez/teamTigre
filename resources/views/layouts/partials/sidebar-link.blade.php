@props(['route', 'icon', 'label', 'color' => null, 'isActive' => null])

@php
    $defaultClasses = 'flex items-center px-4 py-2 rounded-lg transition-colors';
    
    // 🌟 CLASE ACTIVA AJUSTADA: Usa Naranja de fondo y texto Blanco
    $defaultActiveClasses = 'bg-orange-600 text-white'; 

    // CLASE INACTIVA/HOVER: Gris oscuro para el fondo del sidebar.
    $defaultInactiveClasses = 'text-gray-300 hover:bg-gray-700';

    // Selecciona la clase activa: Si se pasó una ruta activa, usa Naranja, si no, usa las clases predeterminadas de inactivo.
    // **NOTA**: La lógica de request()->routeIs() está en el layout principal, aquí solo usamos el prop $isActive
    $activeClasses = $isActive ?? $defaultInactiveClasses;
    
    // Si se pasa un color específico (por ejemplo, para el botón de Login), se usa ese color. Si no, se usa la clase activa/inactiva.
    $styleClasses = $color ? "$color text-white font-semibold" : $activeClasses;
@endphp

<a href="{{ route($route) }}" 
   class="{{ $defaultClasses }} {{ $styleClasses }}"
   {{ $attributes }}>
   
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
    </svg>
    
    {{-- El texto se oculta/muestra con Alpine.js, definido en guest-layout --}}
    <span 
        class="ml-3 whitespace-nowrap transition-opacity duration-300 ease-in-out overflow-hidden" 
        :class="sidebarOpen ? 'opacity-100 max-w-full' : 'opacity-0 max-w-0'"
        x-cloak>
        {{ $label }}
    </span>
</a>