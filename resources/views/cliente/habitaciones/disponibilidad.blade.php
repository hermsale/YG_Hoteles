<x-app-layout>
    <!-- formulario de reserva -->
    <x-formulario-reserva />


    <!-- cito el componente de navbar -->
    <x-navbar />

    <!-- Sección de habitaciones -->
    <section class="bg-gray-900 text-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Detalles y Precios</h2>
            <p class="text-center max-w-6xl mx-auto mb-12">
                YGHoteles ofrece 15 exclusivas habitaciones diseñadas para brindar confort y descanso en el corazón de Las Leñas. Algunas de ellas cuentan con balcones privados con vista a las montañas, y están equipadas con minibar y zona de comedor para quienes prefieren opciones de autoservicio.
                Cada habitación ha sido cuidadosamente insonorizada e incluye un amplio escritorio, ideal tanto para el relax como para el trabajo. Los baños están equipados con bañera y ducha, además de artículos de tocador de cortesía. Algunas habitaciones también ofrecen vistas panorámicas al entorno natural de la cordillera, creando una experiencia única de conexión con la montaña.
            </p>
<!-- class="h-10 w-10 text-yellow-500"  -->
            <!-- esto se ejecuta si no hay habitaciones disponibles para la fecha -->
            @if ($habitaciones->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-md text-yellow-800 mt-8 max-w-2xl mx-auto text-center">
                <div class="flex flex-col items-center space-y-4">
                     <img src="{{ asset('img/otros/no-se-encontro.png') }}" alt="Imagen de no se encontro" class="w-full md:w-1/3 max-h-64 object-cover rounded-lg">

                    <h3 class="text-xl font-semibold">No se encontraron habitaciones disponibles</h3>
                    <p class="text-sm text-gray-700">
                        Lo sentimos, no hay habitaciones que coincidan con los parámetros seleccionados.
                        Te recomendamos modificar las fechas o la cantidad de huéspedes e intentarlo nuevamente.
                    </p>

                    <a href="{{ route('habitaciones.index') }}"
                        class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                        Cambiar búsqueda
                    </a>
                </div>
            </div>
            @endif

            @foreach($habitaciones as $habitacion)
            <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-10 flex flex-col md:flex-row gap-6">
                {{-- Imagen principal --}}
                @php
                $imagenPrincipal = $habitacion->imagenes->first();
                @endphp

                @if($imagenPrincipal)
                <img src="{{ asset($imagenPrincipal->url) }}" alt="Imagen de {{ $habitacion->nombre }}" class="w-full md:w-1/3 max-h-64 object-cover rounded-lg">
                @else
                <img src="{{ asset('img/no-image.png') }}" alt="Sin imagen" class="w-full md:w-1/3 rounded-lg object-cover">
                @endif

                <div class="md:w-2/3">
                    <h3 class="text-xl font-bold mb-2">{{ $habitacion->nombre }}</h3>

                    <p class="mb-4">
                        {{ $habitacion->descripcion }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mb-4">
                        <ul class="list-disc list-inside">
                            <p><strong>Servicios incluidos:</strong></p>
                            @forelse($habitacion->amenities as $amenity)
                            <li>{{ $amenity->nombre }}</li>
                            @empty
                            <li>Sin servicios listados</li>
                            @endforelse
                        </ul>

                        <div>
                            <p>Capacidad de huéspedes: <strong>{{ $habitacion->capacidad }}</strong></p>
                            <p>Categoría: <strong>{{ $habitacion->categoria->nombre ?? 'Sin categoría' }}</strong></p>
                            <p>Código habitación: <strong>{{ $habitacion->codigo_habitacion }}</strong></p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <p><strong>Precio por 1 noche:</strong>
                            <span class="text-green-700 font-semibold">
                                {{ number_format($habitacion->precio_noche, 2, ',', '.') }} ARS
                            </span>
                        </p>
                        <a href="{{ route('reservas.confirmar', [
                                                        'habitacion_id' => $habitacion->id,
                                                        'fecha_entrada' => request('fecha_entrada'),
                                                        'fecha_salida' => request('fecha_salida'),
                                                        'huespedes' => request('huespedes'),
                                ]) }}" class="mt-2 sm:mt-0 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Reservar Ahora
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>



    </section>
</x-app-layout>
