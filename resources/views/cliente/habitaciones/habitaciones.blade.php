<!-- resources/views/cliente/habitaciones.blade.php -->

<x-app-layout>
    <!-- Hero Section con imagen de fondo -->
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('/img/otros/fondo-inicio.png')">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <!-- Buscador centrado -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 bg-white bg-opacity-90 p-6 rounded shadow-lg w-full max-w-md">
            <h2 class="text-center text-xl font-bold mb-4">Reserva Online</h2>
            <form class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Fecha de entrada:</label>
                        <input type="date" class="w-full border rounded px-2 py-1" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Fecha de salida:</label>
                        <input type="date" class="w-full border rounded px-2 py-1" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Huéspedes:</label>
                    <select class="w-full border rounded px-2 py-1">
                        <option>1 Adulto</option>
                        <option>2 Adultos</option>
                        <option>3 Adultos</option>
                        <option>Familia</option>
                    </select>
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Buscar Disponibilidad</button>
            </form>
        </div>
    </section>
 {{-- Tabs --}}
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

       
    </div>
</nav>
    <!-- Sección de habitaciones -->
    <section class="bg-black text-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Detalles y Precios</h2>
            <p class="text-center max-w-3xl mx-auto mb-12">
                YGHoteles ofrece 15 exclusivas habitaciones diseñadas para brindar confort y descanso en el corazón de Las Leñas... <!-- texto abreviado -->
            </p>

            <!-- Repetí este bloque por habitación -->
            <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-10 flex flex-col md:flex-row gap-6">
                <img src="/img/habitaciones/deluxe.png" alt="Habitación Deluxe" class="w-full md:w-1/3 rounded-lg object-cover">
                <div class="md:w-2/3">
                    <h3 class="text-xl font-bold mb-2">Habitación Deluxe con Vista a la Montaña</h3>
                    <p class="mb-4">Disfrutá del máximo confort en nuestra Habitación Deluxe...</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mb-4">
                        <ul class="list-disc list-inside">
                            <li>Cama King size</li>
                            <li>Zona de estar</li>
                            <li>Baño privado con ducha y bañera</li>
                            <li>Smart TV</li>
                            <li>Wi-Fi</li>
                        </ul>
                        <ul class="list-disc list-inside">
                            <li>Minibar y cafetera</li>
                            <li>Aire acondicionado</li>
                            <li>Calefacción</li>
                            <li>Caja de seguridad</li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <p><strong>Precio por 1 noche:</strong> <span class="text-green-700 font-semibold">90000 ARS</span></p>
                        <a href="#" class="mt-2 sm:mt-0 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Reservar Ahora</a>
                    </div>
                </div>
            </div>
            <!-- Fin de habitación -->

        </div>
    </section>
</x-app-layout>
