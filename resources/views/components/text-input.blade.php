@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => '
    border-gray-300 
    bg-white 
    text-gray-900 
    
    /* === INICIO DE CORRECCIÓN PARA EL MODO OSCURO === */
    dark:border-gray-700 
    dark:bg-white         /* Cambiado de dark:bg-gray-900 a dark:bg-white */
    !dark:text-gray-900   /* Añadido ! para asegurar el texto oscuro sobre fondo blanco */
    /* === FIN DE CORRECCIÓN === */
    
    focus:border-indigo-500 
    dark:focus:border-indigo-600 
    focus:ring-indigo-500 
    dark:focus:ring-indigo-600 
    rounded-md 
    shadow-sm
']) }}>