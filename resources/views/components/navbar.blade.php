@php
    $current = Route::currentRouteName();
@endphp

<nav class="bg-gray-800 text-center py-3">
    <div class="inline-flex rounded overflow-hidden shadow-lg">
        <a href="{{ route('welcome') }}"
           class="{{ $current === 'welcome' ? 'bg-blue-500' : 'bg-gray-700 hover:bg-gray-600' }} px-4 py-2">
           Descripción
        </a>
        <a href="{{ route('habitaciones.index') }}"
           class="{{ $current === 'habitaciones.index' ? 'bg-blue-500' : 'bg-gray-700 hover:bg-gray-600' }} px-4 py-2">
           Habitaciones
        </a>
        <a href="#"
           class="bg-gray-700 hover:bg-gray-600 px-4 py-2">
           Fotos
        </a>
        <a href="#"
           class="bg-gray-700 hover:bg-gray-600 px-4 py-2">
           Reseñas
        </a>
    </div>
</nav>
