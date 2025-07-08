<x-app-layout>
    <x-navbar />

    <section class="bg-gray-900 text-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-bold">Habitaciones</h2>
                <a href="{{ route('habitaciones.crear') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    ➕ Agregar habitación
                </a>
            </div>

            @forelse($habitaciones as $habitacion)
            <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-10 flex flex-col md:flex-row gap-6">

                {{-- Imagen principal --}}
                @php
                    $imagenPrincipal = $habitacion->imagenes->first();
                @endphp

                <div class="w-full md:w-1/3">
                    @if($imagenPrincipal)
                        <img src="{{ asset($imagenPrincipal->url) }}" alt="Imagen de {{ $habitacion->nombre }}"
                             class="w-full max-h-64 object-cover rounded-lg">
                    @else
                        <img src="{{ asset('img/no-image.png') }}" alt="Sin imagen"
                             class="w-full max-h-64 object-cover rounded-lg">
                    @endif
                </div>

                <div class="md:w-2/3">
                    <h3 class="text-xl font-bold mb-2">{{ $habitacion->nombre }}</h3>
                    <p class="mb-4">{{ $habitacion->descripcion }}</p>

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

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4">
                        <p><strong>Precio por 1 noche:</strong>
                            <span class="text-green-700 font-semibold">
                                {{ number_format($habitacion->precio_noche, 2, ',', '.') }} ARS
                            </span>
                        </p>

                        <div class="mt-4 sm:mt-0 flex gap-2">
                            <a href="{{ route('habitaciones.editar', $habitacion->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('habitaciones.inhabilitar', $habitacion->id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta habitación?')">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    🗑 Pausar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-center text-gray-300 mt-10">No hay habitaciones registradas aún.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>
